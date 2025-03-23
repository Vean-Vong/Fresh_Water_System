<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Retrieve all employees
        $employees = Employee::all();

        // Format the 'date' fields for each employee
        $employees->transform(function ($employee) {
            $employee->hire_date = Carbon::parse($employee->hire_date)->format('Y-m-d'); // Format hire_date
            $employee->date_of_birth = Carbon::parse($employee->date_of_birth)->format('Y-m-d'); // Format date_of_birth
            return $employee;
        });

        // Return JSON response
        return response()->json($employees, 200);
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            // 'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:15',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            // 'status' => 'required|boolean',
        ]);

        $employee = Employee::create($validatedData);

        return response()->json($employee, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json($employee, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'gender' => 'sometimes|in:Male,Female,Other',
            // 'department' => 'sometimes|string|max:255',
            'position' => 'sometimes|string|max:255',
            'hire_date' => 'sometimes|date',
            'email' => 'sometimes|email|unique:employees,email,' . $id,
            'phone' => 'sometimes|string|max:15',
            'date_of_birth' => 'sometimes|date',
            'address' => 'sometimes|string|max:255',
            // 'status' => 'sometimes|boolean',
        ]);

        $employee->update($validatedData);

        return response()->json($employee, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully'], 200);
    }
}
