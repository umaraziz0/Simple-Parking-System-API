<?php

namespace App\Http\Controllers;

use App\Models\Admins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerAdmin(Request $request)
    {
        /**
         * Example Request
         * {
         *   name: "Admin",
         *   email: "admin@mail.com",
         *   password: "admin",
         *   password_confirmation: "admin",
         * }
         */

        $fields = $request->validate([
            "name" => "required|string",
            "email" => "required|string|unique:admins,email",
            "password" => "required|string|confirmed"
        ]);

        $admin = Admins::create([
            "name" => $fields["name"],
            "email" => $fields["email"],
            "password" => bcrypt($fields["password"])
        ]);

        $token = $admin->createToken("registerToken")->plainTextToken;

        return response([
            "admin" => $admin,
            "token" => $token
        ], 201);
    }

    public function loginAdmin(Request $request)
    {
        /**
         * Example Request
         * {
         *   email: "admin@mail.com",
         *   password: "admin",
         * }
         */

        $fields = $request->validate([
            "email" => "required|string",
            "password" => "required|string"
        ]);

        // ! Validate login
        $admin = Admins::where("email", $fields["email"])->first();
        $passwordCheck = Hash::check($fields["password"], $admin->password);

        if (!$admin || $passwordCheck) {
            return response(["message" => "Invalid credentials"], 401);
        }

        $token = $admin->createToken("loginToken")->plainTextToken;

        return response([
            "admin" => $admin,
            "token" => $token
        ], 201);
    }

    public function logoutAdmin(Request $request)
    {
        if (!$request->user()->currentAccessToken()->delete()) {
            return response(["message" => "Authentication token not found."], 404);
        };

        return response(["message" => "Logged out."], 200);
    }
}
