<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            $employee = Employee::select('*')->with('company');
            return datatables()->of($employee)
            ->addColumn('action', 'employees.action')
            ->addColumn('company', function(Employee $employee) {
                return $employee->company->name;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('employees.index'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::get()->pluck('name','id')->toArray();
        return view('employees.edit',compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $input = $request->except('_token');
        Employee::create($input);
        return redirect()->route('employees.index')
        ->with('success','Employee has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            return view('employees.show',compact('employee'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $companies = Company::get()->pluck('name','id')->toArray();

            $employee = Employee::findOrFail($id);
            return view('employees.edit',compact('employee','companies'));
        } catch (\Exception $e) {
            abort(404);
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, string $id)
    {
        $input = $request->except('_token','_method');
        try {
            $employee = Employee::findOrFail($id);
            if($employee){
                $employee->update($input);
            }
        return redirect()->route('employees.index')
            ->with('success','Employee Has Been updated successfully');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)// string $id
    {
        $input = $request->only('id');
        $company = Employee::where('id',$input['id']);
        if($company){
            $company->delete();
        }
        return Response()->json($company);        
    }
}
