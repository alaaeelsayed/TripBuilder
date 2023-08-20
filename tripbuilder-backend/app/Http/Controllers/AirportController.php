<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $airports = Airport::all();
        return response()->json(["data" => $airports]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedRequest = $request->validate([
            'code' => 'required|string|max:3|unique:airports',
            'name' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'city_code' => 'required|string|max:3',
            'city' => 'required|string',
            'country_code' => 'required|string|max:2',
            'timezone' => 'required|string',
        ]);

        $airport = Airport::create($validatedRequest);
        return response()->json(["data" => $airport], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $airport = Airport::findOrFail($code);
        return response()->json(["data" => $airport]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $code)
    {
        $validatedRequest = $request->validate([
            'name' => 'sometimes|required|string',
            'latitude' => 'sometimes|required|numeric',
            'longitude' => 'sometimes|required|numeric',
            'city_code' => 'sometimes|required|string|max:3',
            'city' => 'sometimes|required|string',
            'country_code' => 'sometimes|required|string|max:2',
            'timezone' => 'sometimes|required|string',
        ]);

        $airport = Airport::findOrFail($code);
        $airport->update($validatedRequest);

        return response()->json(["data" => $airport]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($code)
    {
        $airport = Airport::findOrFail($code);
        $airport->delete();

        return response()->json(null, 204);
    }
}
