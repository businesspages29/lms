<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Notifications\CompanyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            $user = Company::select('*');
            return datatables()->of($user)
            ->addColumn('action', 'companies.action')
            ->addColumn('logo_url', function($data) {
                return '<img src="'.$data->logo_url.'" width="95px"/>';
            })
            ->rawColumns(['action','logo_url'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('companies.index'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        $input = $request->except('_token');
        if($request->hasFile('logo')){
            $file= $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = Str::uuid().'.'.$extension;
            $filePath = 'logos/' . $filename; // Specify the desired path and the generated filename
            Storage::disk('public')->put($filePath, file_get_contents($file));
            $input['logo'] = $filename;
        }
        $company = Company::create($input);
        try {
            $company->notify(new CompanyNotification());
        } catch (\Exception $e) {
            
        }        
        return redirect()->route('companies.index')
        ->with('success','Company has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $company = Company::findOrFail($id);
            return view('companies.show',compact('company'));
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
            $company = Company::findOrFail($id);
            return view('companies.edit',compact('company'));
        } catch (\Exception $e) {
            abort(404);
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyRequest $request, string $id)
    {
        $input = $request->except('_token','_method');
        try {
            $company = Company::findOrFail($id);
            if($request->hasFile('logo')){
                if(!empty($company->logo) && Storage::disk('public')->exists("logos/".$company->logo)){
                    Storage::disk('public')->delete("logos/".$company->logo);
                }                
                $file= $request->file('logo');
                $extension = $file->getClientOriginalExtension();
                $filename = Str::uuid().'.'.$extension;
                $filePath = 'logos/' . $filename; // Specify the desired path and the generated filename
                Storage::disk('public')->put($filePath, file_get_contents($file));
                $input['logo'] = $filename;
            }
            if($company){
                $company->update($input);
            }
        return redirect()->route('companies.index')
            ->with('success','Company Has Been updated successfully');
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
        $company = Company::where('id',$input['id']);
        if($company){
            $company->delete();
        }
        return Response()->json($company);        
    }
}
