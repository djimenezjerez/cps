<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function me()
    {
        return [
            'message' => 'Usuario actual',
            'payload' => Auth::user(),
        ];
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($request->only(['username', 'password']))) {
            $user = Auth::user();
            $token = $user->getRememberToken();
            if (!$token) {
                $token = $user->createToken('api')->plainTextToken;
                $user->setRememberToken($token);
                $user->save();
            }
            return [
                'message' => 'Bienvenido',
                'payload' => [
                    'access_token' => $token,
                    'user' => $user,
                ],
            ];
        }
        return response()->json([
            'message' => 'Credenciales inválidas',
            'errors' => [
                'password' => ['Usuario o contraseña incorrecta'],
            ],
        ], 401);
    }

    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
            $user->setRememberToken(null);
            $user->save();
        }
        return [
            'message' => 'Sesión finalizada',
        ];
    }
}
