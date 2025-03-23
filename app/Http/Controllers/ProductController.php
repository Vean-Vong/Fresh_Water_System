<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'filtration_stage' => 'required|integer',
            'cold_water_tank_capacity' => 'required|string|max:255', // Handling as string (e.g., "8L")
            'hot_water_tank_capacity' => 'required|string|max:255', // Handling as string (e.g., "3L")
            'heating_capacity' => 'required|string|max:255', // Handling as string (e.g., "80C")
            'cold_power_consumption' => 'required|string|max:255', // Handling as string (e.g., "100W")
            'hot_power_consumption' => 'required|string|max:255', // Handling as string (e.g., "300W")
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validate the image
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Handle the image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public'); // store in 'products' folder
        }

        // Create product and save data
        $product = Product::create([
            'model' => $request->model,
            'color' => $request->color,
            'filtration_stage' => $request->filtration_stage,
            'cold_water_tank_capacity' => $request->cold_water_tank_capacity,
            'hot_water_tank_capacity' => $request->hot_water_tank_capacity,
            'heating_capacity' => $request->heating_capacity,
            'cold_power_consumption' => $request->cold_power_consumption,
            'hot_power_consumption' => $request->hot_power_consumption,
            'quantity' => $request->quantity,
            'image' => $imagePath, // Save image path to database
        ]);

        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'model' => 'sometimes|string|max:255',
            'color' => 'sometimes|string|max:255',
            'filtration_stage' => 'nullable|string',
            'cold_water_tank_capacity' => 'sometimes|string|max:255',
            'hot_water_tank_capacity' => 'sometimes|string|max:255',
            'heating_capacity' => 'sometimes|string|max:255', // Handling as string (e.g., "80C")
            'cold_power_consumption' => 'sometimes|string|max:255', // Handling as string (e.g., "100W")
            'hot_power_consumption' => 'sometimes|string|max:255', // Handling as string (e.g., "300W")
            'quantity' => 'sometimes|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Only update the image if a new one is uploaded
        if ($request->hasFile('image')) {
            // If there's an old image, delete it from storage
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;  // Store the new image path (relative)
        }

        // Update other fields
        $product->update($request->only([
            'model',
            'color',
            'filtration_stage',
            'cold_water_tank_capacity',
            'hot_water_tank_capacity',
            'heating_capacity',
            'cold_power_consumption',
            'hot_power_consumption',
            'quantity'
        ]));

        // Return the updated product
        return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}