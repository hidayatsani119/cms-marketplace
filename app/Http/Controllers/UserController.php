<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(UserLoginRequest $request) :JsonResponse
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new HttpResponseException(response()->json([
                'errors' => 'The provided credentials are incorrect.',
            ],400));
        }

        //generate token uuid
        $user->token = Str::uuid()->toString();
        $user->save();

        return response()->json([
            'message' => 'Login successful',
            'token' => new UserResource($user),
        ],200);

    }

    public function get(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'message' => 'Get user success.',
            'data' => new UserResource($user),
        ]);
    }

    public function logout(Request $request) :JsonResponse
    {
        $User = Auth::user();
        $User->token = null;
        $User->save();

        return response()->json([
            'errors' => 'Unauthorized.',
        ],401);
    }
}
