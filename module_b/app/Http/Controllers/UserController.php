<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request) {
        $data = $request->validate([
            "password" => "required|string",
        ]);

        $user = User::query()->where("password", $data["password"])->first();
        if (!$user) {
            return redirect()->back()->with(["error" => "Wrong password"]);
        }

        Auth::login($user);
        return redirect('/');
    }
}
