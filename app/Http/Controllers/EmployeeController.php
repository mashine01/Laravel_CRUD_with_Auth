<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\employee;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;



class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = employee::all();
        return view('employee.index')->with("employees", $employees);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => [
            'required',
            'string', 
            'regex:/^[a-zA-Z\s]+$/', 
            'max:255',
            ],
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|numeric|digits:11',
        ],
        [
            'fullname.required' => "Please enter your Full Name",
            'fullname.regex' => 'The Name can only contain alphabets',
        ]
    );

        if ($validator->fails()) {
            return redirect(route('employee.create'))
                        ->withErrors($validator)
                        ->withInput();
        }

        $validated = $validator->validated();

        $newEmployee = employee::create($validated);

        return(redirect(route("employee.index")));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(employee $employee)
    {
        return view("employee.edit", ["employee" => $employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(employee $employee, Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fullname' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('employees')->ignore($employee->id),
            ],
            'phone' => 'required|string|digits:11',
        ],
        [
            'fullname.required' => "Please enter your Full Name",
            'fullname.regex' => 'The Name can only contain alphabets',
        ]);

        $validator->messages()->add('fullname.regex', 'The :attribute must contain only letters and spaces.');

        if ($validator->fails()) {
            return redirect(route('employee.edit', ['employee' => $employee]))
                        ->withErrors($validator)
                        ->withInput();
        }

        $validated = $validator->validated();
        $employee->update($validated);
        return redirect()->route('employee.index')->with('success', 'Employee updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(employee $employee, Request $request)
    {
        $employee->delete();
        return redirect(route('employee.index'))->with('success', 'Employee deleted successfully');
    }
}