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
    
    private function GetUserInformation() {
        
        $user = new \stdClass();
        $user->id = Auth::id();
        $user->email = DB::select('SELECT email FROM users WHERE id=?', [$user->id])[0]->email;

        // Getting information about the logged in user from the database
        return $user;
    }

    private function CheckTwoFactorIsEnabled() {

        $user = $this->GetUserInformation();

        $validation = DB::select('SELECT two_factor_enabled FROM users WHERE id=?', [$user->id]);

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
       
        $user = $this->GetUserInformation();

        return DB::select('SELECT * FROM stored_passwords WHERE fk_user_email=?',[$user->email]);
    }


    private function GeneratePassword($length = 10) {
        
        $random = str_shuffle("abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%&!$%&");
        $password = substr($random, 0, $length);

        return $password;
    }

    public function StoreNewPassword(Request $request) {

        // If the user did not enter password, we will autogenerate one
        if(empty($request->input('password'))) {
            $password = $this->GeneratePassword(12);
        } else {
            $password = $request->input('password');
        }

        $user = $this->GetUserInformation();

        $timestamp = date('Y-m-d H:m:s');

        DB::table('stored_passwords')->insert([
            'fk_user_email' => $user->email,
            'username' => $request->input('username'),
            'password_assosiation_alias' => $request->input('password-assosiation-alias'),
            'stored_password' => Crypt::encryptString($password),
            'created_at' => $timestamp
        ]);
        return redirect()->route('home');
    }

    public function GetStoredPassword(Request $request) {

        $user = $this->GetUserInformation();

        $data = [$user->email, $request->input('username'), $request->input('password-assosiation-alias'), $request->input('password')];
        $encryptedPassword = DB::select('SELECT stored_password FROM stored_passwords WHERE fk_user_email=? AND username=? AND password_assosiation_alias=? AND stored_password=?', $data)[0]->stored_password;
        $password = Crypt::decryptString($encryptedPassword);
        return $password;

    }

    public function ValidateTwoFactor() {

    }
}
