<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 * @package App\Http\Controllers
 * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
     */
    public function auth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|min:5',
            'password' => 'required|min:4'
        ]);

        if($validator->fails()) {
            return $this->_errorResponse(
                'The request can not be validated. Required parameters: email, password'
            );
        }

        if (!Auth::attempt([
            'email' => $request->all()['email'],
            'password' => $request->all()['password']],
            true))
        {
            return $this->_errorResponse('Auth credentials is not valid');
        }


        if(!$token = Auth::user()->createToken('Token')->accessToken) {
            return $this->_errorResponse('Couldt generate token');
        } else {
            return response()->json([
                'data' => [
                    'token' => $token
                ]
            ]);
        }

    }
}
