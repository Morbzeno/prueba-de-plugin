<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $User = new User;
        $User->name = $request->name;
        $User->email = $request->email;
        $User->password = Hash::make($request->password);

        $User->save();

        // Mail::to($User->email)->send(new SendMail($User->name));
        return response()->json([
            'message' => 'User insertado',
            'data' => $User,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser un email válido',
            'password.required' => 'El campo contraseña es obligatorio',
        ]);

        $User = User::where('email', $request->email)->first();

        if (! $User || ! Hash::check($request->password, $User->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $token = Str::random(60);

        $User->remember_token = $token;
        $User->save();

        $User->makeHidden(['token']);

        return response()->json([
            'message' => 'Login correcto',
            'token' => $token,
            'User' => $User,
        ]);
    }
}
