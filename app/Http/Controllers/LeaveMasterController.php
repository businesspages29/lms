<?php

namespace App\Http\Controllers;

use App\Models\LeaveMaster;
use Illuminate\Http\Request;

class LeaveMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(LeaveMaster::select('*'))
            ->addColumn('action', 'leavemaster.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('leavemaster.index'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leavemaster.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $input = $request->only('name');
        LeaveMaster::create([
            'name' => $input['name']
        ]);
        return redirect()->route('leave-master.index')
        ->with('success','Leave master has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $role = LeaveMaster::findOrFail($id);
            return view('leavemaster.edit',compact('role'));
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
            $role = LeaveMaster::findOrFail($id);
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
        $role = LeaveMaster::where('id',$input['id']);
        if($role){
            $role->delete();
        }
        return Response()->json($role);
    }
}
