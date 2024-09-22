<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        if ($token) {
            // Store token in session
            session(['access_token' => $token]);

            // Redirect to dashboard if token is valid
            return redirect()->route('dashboard');
        }

        return response()->json([
                'message' => 'Token generation failed'
            ], 500);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ],
                401
            );
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        if ($token) {
            // Store token in session
            session(['access_token' => $token]);
            
            // Redirect to dashboard if token is valid
            return redirect()->route('dashboard');
        }

        return response()->json([
                'message' => 'Token generation failed'
            ], 500);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}

