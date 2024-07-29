<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        $data = [
            "message" => "usuarios obtenidos",
            "users" => $users,
            "status" => 200,
        ];

        return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'requred|min:8|confirmed',
            'carnet' => 'nullable|string|max:255',
            'domicilio' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            $data = [
                "message" => "error al validar el usuario",
                "error" => $validator->errors(),
                "status" => 422,
            ];
            return response()->json($data, 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $data = [
            "message" => "usuario creado",
            "user" => $user,
            "status" => 201,
        ];

        return response()->json($data, 201);
    }
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            $data = [
                "message" => "usuario no encontrado",
                "status" => 404,
            ];

            return response()->json($data, 404);
        }
        $data = [
            "message" => "usuario encontrado",
            "user" => $user,
            "status" => 200,
        ];

        return response()->json($data, 200);
    }
}
