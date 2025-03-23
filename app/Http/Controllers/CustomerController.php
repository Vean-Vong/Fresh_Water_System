<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all customers paginated
        $customers = Customer::paginate(10);

        // Format the 'date' field for each customer
        $customers->getCollection()->transform(function ($customer) {
            $customer->date = Carbon::parse($customer->date)->format('Y-m-d'); // Format date to 'YYYY-MM-DD'
            return $customer;
        });

        // Fetch recent customers
        $recentCustomers = Customer::latest()->take(5)->get()->map(function ($customer) {
            $customer->date = Carbon::parse($customer->date)->format('Y-m-d'); // Format date to 'YYYY-MM-DD'
            return $customer;
        });
        return response()->json([
            'customers' => $customers,
            'recentCustomers' => $recentCustomers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'date' => 'required|date',
            'job' => 'required|string|max:100',
        ]);

        $customer = Customer::create($validatedData);

        // Format the 'date' field
        $customer->date = Carbon::parse($customer->date)->format('Y-m-d');

        return response()->json([
            'message' => 'Customer added successfully.',
            'customer' => $customer,
        ], 201);
    }


    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json($customer, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'date' => 'required|date',
            'job' => 'required|string|max:100',
        ]);

        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        $customer->update($validatedData);

        // Format the 'date' field
        $customer->date = Carbon::parse($customer->date)->format('Y-m-d');

        return response()->json([
            'message' => 'Customer updated successfully.',
            'customer' => $customer,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Customer deleted successfully.',
            'customer' => $customer, // Return deleted customer for consistency
        ]);
    }
}
