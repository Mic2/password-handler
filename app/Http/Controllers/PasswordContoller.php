<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function Index() {

        $data = [];

        return View('frontpage', compact('data'));
    }

    public function StoreNewPassword(Request $request) {

        // Getting the username and password wich we will store
        // (MAYBE we should actually just generate a new strong password. IF ITS EMPTY!)
        print_r($request->input('password-assosiation-alias'));
        print_r($request->input('password'));
    }
}