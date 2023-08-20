<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class TripController extends Controller

{
    /**
     * Search for available trips based on criteria.
     *
     * This endpoint provides a way to search for available flights based on a set of criteria 
     * such as departure and arrival locations, flight type, and other optional parameters.
     *
     * @group Trips
     *
     * @queryParam from string required The airport code for the departure location. Example: YUL
     * @queryParam to string required The airport code for the arrival location. Example: YVR
     * @queryParam type string required Type of the flight. Must be one of: 'one-way', 'roundtrip'. Example: one-way
     * @queryParam pagesize integer The number of results to return per page. Minimum: 1, Maximum: 100. Example: 10
     * @queryParam airline string An optional filter to search flights by specific airlines. Example: AC
     * @queryParam maxduration integer An optional filter for the maximum duration of flights in minutes. Example: 1800
     * @queryParam maxprice integer An optional filter for the maximum price of flights. Example: 3000
     * @queryParam sortby string An optional sorting parameter. Must be one of: 'price', 'duration'. Example: price
     *
     **/
    public function search(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|string',
            'to' => 'required|string',
            'type' => 'required|in:one-way,roundtrip',
            'pagesize' => 'sometimes|integer|min:1|max:100',
            'airline' => 'sometimes|string',
            'maxduration' => 'sometimes|integer',
            'maxprice' => 'sometimes|integer',
            'sortby' => 'sometimes|in:price,duration'
        ]);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pageSize = $validated['pagesize'] ?? 10;

        $cacheKey = "tripsearch:from={$validated['from']}&to={$validated['to']}&type={$validated['type']}&pagesize={$pageSize}&page={$currentPage}";
        $cacheKey .= "&airline=" . ($validated['airline'] ?? '') . "&maxduration=" . ($validated['maxduration'] ?? '') . "&maxprice=" . ($validated['maxprice'] ?? '') . "&sortby=" . ($validated['sortby'] ?? '');

        return Cache::remember($cacheKey, 60, function () use ($validated, $pageSize, $currentPage) {
            $outboundQuery = Flight::with(['departureAirport', 'arrivalAirport'])
                ->whereHas('departureAirport', function ($q) use ($validated) {
                    $q->where('code', $validated['from']);
                })
                ->whereHas('arrivalAirport', function ($q) use ($validated) {
                    $q->where('code', $validated['to']);
                });

            $this->filterQuery($outboundQuery, $validated);


            if ($validated['type'] === 'one-way') {
                $outboundFlights = $outboundQuery->paginate($pageSize);

                $transformedFlights = $outboundFlights->map(function ($flight) {
                    $this->includeExtraData($flight);
                    return [
                        'outbound' => $flight,
                        'total_distance' => $this->calculateDistance($flight),
                        'total_price' => $flight->price,
                        'total_duration' => $flight->duration
                    ];
                });

                return response()->json([
                    'data' => $transformedFlights->all(),
                    'pagination' => [
                        'current_page' => $outboundFlights->currentPage(),
                        'total' => $outboundFlights->lastPage(),
                    ]
                ]);
            } elseif ($validated['type'] === 'roundtrip') {
                $outboundFlights = $outboundQuery->get();
                foreach ($outboundFlights as $flight) {
                    $this->includeExtraData($flight);
                }

                $inboundQuery = Flight::with(['departureAirport', 'arrivalAirport'])
                    ->whereHas('departureAirport', function ($q) use ($validated) {
                        $q->where('code', $validated['to']);
                    })
                    ->whereHas('arrivalAirport', function ($q) use ($validated) {
                        $q->where('code', $validated['from']);
                    });

                if (isset($validated['airline'])) {
                    $inboundQuery->where('airline', $validated['airline']);
                }

                $inboundFlights = $inboundQuery->get();

                foreach ($inboundFlights as $flight) {
                    $this->includeExtraData($flight);
                }

                $roundtrips = [];
                foreach ($outboundFlights as $outbound) {
                    foreach ($inboundFlights as $inbound) {
                        $timeInterval = $this->calculateTimeInterval($outbound, $inbound);

                        // Make sure inbound leaves at least an hour after inbound flight arrives
                        if ($timeInterval->invert === 0 && ($timeInterval->h > 1 || $timeInterval->d > 0)) {
                            $totalDistance = $this->calculateDistance($outbound) + $this->calculateDistance($inbound);
                            $totalPrice = round($outbound->price + $inbound->price, 2);
                            $totalDuration = $outbound->duration + $inbound->duration;

                            $roundtrips[] = [
                                'outbound' => $outbound,
                                'inbound' => $inbound,
                                'total_distance' => $totalDistance,
                                'total_price' => $totalPrice,
                                'total_duration' => $totalDuration
                            ];
                        }
                    }
                }
                $this->filterRoundTrips($roundtrips, $validated);

                $tripsCollection = collect($roundtrips);
                $currentPageTrips = $tripsCollection->slice(($currentPage - 1) * $pageSize, $pageSize)->all();
                $paginatedRoundTrips = new LengthAwarePaginator($currentPageTrips, count($tripsCollection), $pageSize);

                return response()->json([
                    'data' => $paginatedRoundTrips->all(),
                    'pagination' => [
                        'current_page' => $paginatedRoundTrips->currentPage(),
                        'total' => $paginatedRoundTrips->lastPage(),
                    ]
                ]);
            }
        });
    }

    private function filterRoundTrips(&$roundtrips, $validated)
    {
        if (isset($validated['maxduration'])) {
            $roundtrips = array_filter($roundtrips, function ($trip) use ($validated) {
                return $trip['total_duration'] <= $validated['maxduration'];
            });
        }

        if (isset($validated['maxprice'])) {
            $roundtrips = array_filter($roundtrips, function ($trip) use ($validated) {
                return $trip['total_price'] <= $validated['maxprice'];
            });
        }

        if (isset($validated['sortby'])) {
            usort($roundtrips, function ($a, $b) use ($validated) {
                return $a['total_' . $validated['sortby']] <=> $b['total_' . $validated['sortby']];
            });
        }
    }

    private function filterQuery($query, $validated)
    {
        if (isset($validated['airline'])) {
            $query->where('airline', $validated['airline']);
        }

        if (isset($validated['maxduration'])) {
            $query->where('duration', '<=', $validated['maxduration']);
        }

        if (isset($validated['maxprice'])) {
            $query->where('price', '<=', $validated['maxprice']);
        }

        if (isset($validated['sortby'])) {
            $query->orderBy($validated['sortby'], 'asc');
        }
    }

    private function includeExtraData($flight)
    {
        $flightArrivalTime = $this->calculateArrivalTime($flight);
        $flightArrivalTime->setTimezone(new \DateTimeZone($flight->arrivalAirport->timezone));
        $flight->arrival_time = $flightArrivalTime->format('H:i');
    }

    private function calculateDistance($flight)
    {
        $departureAirport = $flight->departureAirport;
        $arrivalAirport = $flight->arrivalAirport;

        $earthRadius = 6371;

        $latDiff = deg2rad($arrivalAirport->latitude - $departureAirport->latitude);
        $lonDiff = deg2rad($arrivalAirport->longitude - $departureAirport->longitude);

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
            cos(deg2rad($departureAirport->latitude)) * cos(deg2rad($departureAirport->latitude)) *
            sin($lonDiff / 2) * sin($lonDiff / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 0);
    }

    private function calculateArrivalTime($flight)
    {
        $departureAirport = $flight->departureAirport;
        $departureTime = new \DateTime(
            $flight->departure_time,
            new \DateTimeZone($departureAirport->timezone)
        );
        return $departureTime->add(
            new \DateInterval('PT' . $flight->duration . 'M')
        );
    }

    private function calculateTimeInterval($outbound, $inbound)
    {
        $inboundDepartureAirport = $inbound->departureAirport;
        $inboundDepartureTime = new \DateTime(
            $inbound->departure_time,
            new \DateTimeZone($inboundDepartureAirport->timezone)
        );

        $outboundDepartureAirport = $outbound->departureAirport;
        $outboundDepartureTime = new \DateTime(
            $outbound->departure_time,
            new \DateTimeZone($outboundDepartureAirport->timezone)
        );
        $outboundArrivalTime = $outboundDepartureTime->add(
            new \DateInterval('PT' . $outbound->duration . 'M')
        );

        return $outboundArrivalTime->diff($inboundDepartureTime);
    }
}
