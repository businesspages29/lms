<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            $user = User::select('*');
            return datatables()->of($user)
            ->addColumn('action', 'users.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('users.index'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email',            
            'password' => 'required',
        ]);
        $input = $request->except('_token');
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }
        User::create($input);
        return redirect()->route('users.index')
        ->with('success','User has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('users.show',compact('user'));
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
            $user = User::findOrFail($id);
            return view('users.edit',compact('user'));
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
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email,'.$id,
        ]);
        $input = $request->except('_token','_method');
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            unset($input['password']);
        }
        try {
            $user = User::findOrFail($id);
            if($user){
                $user->update($input);
            }
        return redirect()->route('users.index')
            ->with('success','User Has Been updated successfully');
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
        $user = User::where('id',$input['id']);
        if($user){
            $user->delete();
        }
        return Response()->json($user);
        
    }
}
