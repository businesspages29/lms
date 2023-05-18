<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CompanyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matrimonial = Company::paginate(10);
        $rep = CompanyResource::collection($matrimonial);
        return $this->sendResponse($rep,"Company List Successfully");
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
        $rep = new CompanyResource($company);

        return $this->sendResponse($rep,"Company has been created successfully");

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
            $rep = new CompanyResource($company);
            return $this->sendResponse($rep,"Company Has Been updated successfully");
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)// 
    {
        $company = Company::find($id);
        if($company){
            $company->delete();
        }
        return $this->sendResponse([],"Company Has Been delete successfully");       
    }
}
