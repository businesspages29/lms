<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLeaveMaster;
use Illuminate\Http\Request;

class EmployeeLeaveMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        if(request()->ajax()) {
            return datatables()->of(EmployeeLeaveMaster::
            UserId($id)
            ->select('*'))
            ->addColumn('action', 'users.leave.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('users.leave.index'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.leave.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id,Request $request)
    {
        $request->validate([
            'leave_master_id' => 'required',
            'from_date' => 'required|date|after:today',
            'to_date' => 'required|date|after_or_equal:from_date',
            'comment' => 'required|max:300',
        ]);
        $input = $request->except('_token');
        $input['user_id'] = $id;
        $input['number_of_days'] = date_range_count($input['from_date'],$input['to_date']);
        EmployeeLeaveMaster::create($input);
        return redirect()->route('leave-master.index')
        ->with('success','Leave master has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $role = EmployeeLeaveMaster::findOrFail($id);
            return view('users.leave.edit',compact('role'));
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
            'name' => 'required',
        ]);
        $input = $request->only('name');
        try {
            $role = EmployeeLeaveMaster::findOrFail($id);
            if($role){
                $role->update($input);
            }
        return redirect()->route('leave-master.index')
            ->with('success','Leave master Has Been updated successfully');
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
        $role = EmployeeLeaveMaster::where('id',$input['id']);
        if($role){
            $role->delete();
        }
        return Response()->json($role);
    }
}
