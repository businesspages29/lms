<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AuthResource;

class LoginController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError("Validation Error.",$validator->errors());
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $response =  new AuthResource($user);
            return $this->sendResponse($response,"User login succussfully");
        } else {
            return $this->sendError("Unauthorised",['Unauthorised']);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse((object) [],"User Logout succussfully");
    }

    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->sendResponse((object) [],"User Logout All succussfully");
    }
}
