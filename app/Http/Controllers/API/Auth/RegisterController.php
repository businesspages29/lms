<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AuthResource;
use App\Models\User;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|max:16',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->sendError("Validation Error.",$validator->errors());
        }
        $input = $request->only(['name', 'email', 'password']);
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        // Without Reource 
        // $response['token'] =  $user->createToken('MyApp')->plainTextToken;
        // $response['name'] =  $user->name;
        // Using Resource 
        $response =  new AuthResource($user);
        return $this->sendResponse($response,"User login succussfully");
    }
}
