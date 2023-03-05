<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Role::select('*'))
            ->addColumn('action', 'roles.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('roles.index'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);
        $input = $request->only('name');
        Role::create([
            'name' => $input['name']
        ]);
        return redirect()->route('roles.index')
        ->with('success','Role has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $role = Role::findOrFail($id);
            return view('roles.show',compact('role'));
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
            $role = Role::findOrFail($id);
            return view('roles.edit',compact('role'));
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
            'name' => 'required|unique:roles,name,'.$id,
        ]);
        $input = $request->only('name');
        try {
            $role = Role::findOrFail($id);
            if($role){
                $role->update($input);
            }
        return redirect()->route('roles.index')
            ->with('success','Role Has Been updated successfully');
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
        $role = Role::where('id',$input['id']);
        if($role){
            $role->delete();
        }
        return Response()->json($role);
        
    }
}
