<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class PasswordController extends Controller
{
    public function Index() {

        $data = $this->GetStoredPasswordsForViewList();

        return View('frontpage', compact('data'));
    }

    public function GetStoredPasswordsForViewList() {
        return DB::select('SELECT * FROM stored_passwords WHERE fk_user_email=?',["michael_b_hansen@live.dk"]);
    }

    public function StoreNewPassword(Request $request) {

        $timestamp = date('Y-m-d H:m:s');

        DB::table('stored_passwords')->insert([
            'fk_user_email' => "michael_b_hansen@live.dk",
            'username' => $request->input('username'),
            'password_assosiation_alias' => $request->input('password-assosiation-alias'),
            'stored_password' => Crypt::encryptString($request->input('password')),
            'created_at' => $timestamp
        ]);

        /*$encryptedPassword = DB::select('SELECT stored_password FROM stored_passwords where fk_user_email=?', ['michael_b_hansen@live.dk'])[0]->stored_password;
        $password = Crypt::decryptString($encryptedPassword);

        print_r($password);*/

        // HARDCODING user email until we have user management on the site
        //DB::insert('INSERT INTO stored_passwords (fk_user_email, password_assosiation_alias, username, stored_password) VALUES (?,?,?,?)', ["michael_b_hansen@live.dk", $request->input('username'), $request->input('password-assosiation-alias'), $request->input('password')]);      

        // Getting the username and password wich we will store
        // (MAYBE we should actually just generate a new strong password. IF ITS EMPTY!)
    }

    public function GetStoredPassword(Request $request) {

        $data = ["michael_b_hansen@live.dk", $request->input('username'), $request->input('password-assosiation-alias'), $request->input('password')];
        $encryptedPassword = DB::select('SELECT stored_password FROM stored_passwords WHERE fk_user_email=? AND username=? AND password_assosiation_alias=? AND stored_password=?', $data)[0]->stored_password;
        $password = Crypt::decryptString($encryptedPassword);
        return $password;

    }
}