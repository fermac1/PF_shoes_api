<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // public function register(RegisterRequest $request)
    // {
    //     try {
    //         // $validated = $request->validated();

    //         $validator = Validator::make($request->all());

    //         if ($validator->fails()) {
    //             return response()->json(['errors' => $validator->errors()], 422);
    //         }

    //         $validated = $validator->validated();
    //         // register user
    //         $user = User::create([
    //             'first_name' => $validated['first_name'],
    //             'last_name' => $validated['last_name'],
    //             'email' => $validated['email'],
    //             'password' => bcrypt($validated['password']),
    //             'phone_number' => $validated['phone_number'],
    //             'shipping_address' => $validated['shipping_address']
    //         ]);

    //         return response()->json($user, 201);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'message' => 'An error occurred while registering the user.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }

    // }

    public function register(RegisterRequest $request)
    {

        $rules = $request->rules();

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone_number' => $validated['phone_number'],
            'shipping_address' => $validated['shipping_address']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!'
        ], 200);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        // $credentials = $request->only('email', 'password');
        if (! $token = JWTAuth::attempt($validated)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);
        // if (Auth::attempt($validated)) {
        //     $user = User::where('email', $validated['email'])->first();

        //     if (!$user || !Hash::check($validated['password'], $user->password)) {
        //         return response()->json(['message' => 'Invalid credentials.'], 401);
        //     }

        //     $token = $user->createToken($user->first_name.'-AuthToken')->plainTextToken;


        //     // $token = $user->createToken(Str::random(10))->plainTextToken;

        //     return response()->json([
        //         'message' => 'Login Successful',
        //         'token' => $token
        //     ], 200);


        // }

        $cookie = cookie('jwt', $token, 60, null, null, true, true);

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'token' => $token
        ], 200)->withCookie($cookie);

    }
}
