<?php

namespace App\Http\Controllers;

use App\Models\NonWorkingDay;
use Illuminate\Http\Request;

class NonWorkingDayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(NonWorkingDay::select('*'))
            ->addColumn('action', 'nonworkingday.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('nonworkingday.index'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('nonworkingday.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);
        $input = $request->only('date');
        NonWorkingDay::create([
            'date' => $input['date']
        ]);
        return redirect()->route('non-working-day.index')
        ->with('success','non-working-day has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $role = NonWorkingDay::findOrFail($id);
            return view('nonworkingday.edit',compact('role'));
        } catch (\Exception $e) {
            abort(404);
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'required|date',
        ]);
        $input = $request->only('date');
        try {
            $role = NonWorkingDay::findOrFail($id);
            if($role){
                $role->update($input);
            }
        return redirect()->route('non-working-day.index')
            ->with('success','non-working-day Has Been updated successfully');
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
        $role = NonWorkingDay::where('id',$input['id']);
        if($role){
            $role->delete();
        }
        return Response()->json($role);
    }
}
