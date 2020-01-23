<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $user;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Default this will be false.
        $data['isTwoFactorEnabled'] = false;

        // Check if two factor is enabled in the database
        $data['isTwoFactorEnabled'] = $this->CheckTwoFactorIsEnabled();

        $data['passwords'] = $this->GetStoredPasswordsForViewList();
        return View('home', compact('data'));
    }

    private function CheckTwoFactorIsEnabled() {
        
        $user = Auth::user();
        $id = Auth::id();
        $validation = DB::select('SELECT two_factor_enabled FROM users WHERE id=?', [$id]);

        // Checking if enabled or not
        switch ($validation[0]->two_factor_enabled) {
            case 0:
                return false;
            break;
            case 1:
                return true;
            break;
        }
    }

    public function GetStoredPasswordsForViewList() {
       
        $user = Auth::user();
        $id = Auth::id();
        $user = DB::select('SELECT email, secret FROM users WHERE id=?', [$id]);

        return DB::select('SELECT * FROM stored_passwords WHERE fk_user_email=?',[$user[0]->email]);
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

        $user = Auth::user();
        $id = Auth::id();
        $user = DB::select('SELECT email, secret FROM users WHERE id=?', [$id]);

        $data = [$user[0]->email, $request->input('username'), $request->input('password-assosiation-alias'), $request->input('password')];
        $encryptedPassword = DB::select('SELECT stored_password FROM stored_passwords WHERE fk_user_email=? AND username=? AND password_assosiation_alias=? AND stored_password=?', $data)[0]->stored_password;
        $password = Crypt::decryptString($encryptedPassword);
        return $password;

    }

    public function ValidateTwoFactor() {

    }
}
