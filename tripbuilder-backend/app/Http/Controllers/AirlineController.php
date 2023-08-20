<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $airlines = Airline::all();
        return response()->json(["data" => $airlines]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedRequest = $request->validate([
            'code' => 'required|string|max:3|unique:airlines',
            'name' => 'required|string',
        ]);

        $airline = Airline::create($validatedRequest);
        return response()->json(["data" => $airline], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $airline = Airline::findOrFail($code);
        return response()->json(["data" => $airline]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $code)
    {
        $validatedRequest = $request->validate([
            'name' => 'required|string',
        ]);

        $airline = Airline::findOrFail($code);
        $airline->update($validatedRequest);

        return response()->json(["data" => $airline]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($code)
    {
        $airline = Airline::findOrFail($code);
        $airline->delete();

        return response()->json(null, 204);
    }
}
