<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::orderBy('created_at', 'desc')->get();
        return response()->json($cars);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'year' => 'required|integer',
            'price' => 'required|numeric',
            'fuel_type' => 'required|string',
            'transmission' => 'required|string',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string'
        ]);

        $car = Car::create($validated);
        return response()->json(['message' => 'Car uploaded successfully!', 'car' => $car], 201);
    }
}