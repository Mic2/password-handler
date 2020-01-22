<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Google\Authenticator\GoogleAuthenticator;

class BarcodeController extends Controller {
    
    private $g;

    public function __construct() {
        $this->g = new GoogleAuthenticator();
    }

    public function index()
    {
        $user = Auth::user();
        $id = Auth::id();

        // Getting secret from the database
        $user = DB::select('SELECT email, secret, two_factor_enabled FROM users WHERE id=?', [$id]);

        if($user[0]->two_factor_enabled) {
            $barcode = "";
        } else {
            // Generating the barcode image url
            $barcode = $this->g->getURL($user[0]->email, 'password-handler', Crypt::decryptString($user[0]->secret));
        }

        return View('barcode', compact('barcode'));

    }

    public function ValidateTwoFactor(Request $request) {

        if(empty($request->code)) {
            return redirect()->route('home');
        }

        $user = Auth::user();
        $id = Auth::id();

        // Getting secret from the database
        $user = DB::select('SELECT secret FROM users WHERE id=?', [$id]);

        $validation = $this->g->checkCode(Crypt::decryptString($user[0]->secret), $request->code);
        
        $request->session()->put('twoFactorIsValidated', $validation);

        return redirect()->route('home');

    }

    public function EnableTwoFactor() {

        $id = Auth::id();

        DB::table('users')
                ->where('id', $id)
                ->update(['two_factor_enabled' => true]);
    }
}
