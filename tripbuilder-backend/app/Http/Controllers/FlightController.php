<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flights = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])->get();
        return response()->json(["data" => $flights]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedRequest = $request->validate([
            'airline' => 'required|exists:airlines,code',
            'number' => 'required|string',
            'departure_airport' => 'required|exists:airports,code',
            'departure_time' => 'required|date_format:H:i',
            'arrival_airport' => 'required|exists:airports,code',
            'duration' => 'required|integer',
            'price' => 'required|numeric'
        ]);

        $flight = Flight::create($validatedRequest);
        return response()->json(["data" => $flight], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($airline, $number)
    {
        $flight = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])
            ->where('airline', $airline)
            ->where('number', $number)->firstOrFail();

        return response()->json(["data" => $flight]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $airline, $number)
    {
        $validatedRequest = $request->validate([
            'departure_airport' => 'exists:airports,code',
            'departure_time' => 'date_format:H:i',
            'arrival_airport' => 'exists:airports,code',
            'duration' => 'integer',
            'price' => 'numeric'
        ]);

        $flight = Flight::where('airline', $airline)
            ->where('number', $number)->firstOrFail();

        $flight->update($validatedRequest);

        return response()->json(["data" => $flight]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($airline, $number)
    {
        $flight = Flight::where('airline', $airline)
            ->where('number', $number)->firstOrFail();

        $flight->delete();

        return response()->json(null, 204);
    }
}
