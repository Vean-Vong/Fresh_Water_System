<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    // Display a listing of sales
    public function index()
    {
        // Fetch all sales with optional pagination
        $sales = Sale::all();
        // Format the date field for each sale
        $sales->each(function ($sale) {
            $sale->date = Carbon::parse($sale->date)->format('Y-m-d'); // Change format as needed
        });
        return response()->json($sales);
    }

    // Show a specific sale
    public function show($id)
    {
        $sale = Sale::find($id);
        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }
        return response()->json($sale, 200);
    }

    // Store a new sale
    public function store(Request $request)
    {
        $validated = $request->validate([
            'model' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount' => 'nullable|string|max:10', // For example "10%"
            'date' => 'required|date',
            'duration' => 'nullable|string',
            'warranty' => 'nullable|string',
            'seller' => 'required|string|max:255',
            'contract_type' => 'required|in:rental,installment,purchase',
        ]);

        $sale = Sale::create($validated);

        return response()->json($sale, 201); // 201 status for created resource
    }

    // Update an existing sale
    public function update(Request $request, $id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }

        $validated = $request->validate([
            'model' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount' => 'nullable|string|max:10', // For example "10%"
            'date' => 'required|date',
            'duration' => 'nullable|string',
            'warranty' => 'nullable|string',
            'seller' => 'required|string|max:255',
            'contract_type' => 'required|in:rental,installment,purchase',
        ]);

        $sale->update($validated);

        return response()->json($sale);
    }

    // Delete a sale
    public function destroy($id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }

        $sale->delete();

        return response()->json(['message' => 'Sale deleted successfully']);
    }
}
