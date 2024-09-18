<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $redirect_after_login;
    private $gaurd;
    public function __construct() {
        $this->redirect_after_login = '/dashboard';
        $this->gaurd = view()->shared('auth_gaurd');
    }
    public function login() {
        if (auth()->guard($this->gaurd)->check()):
			return redirect($this->redirect_after_login);
		endif;
		return view('auth/login');
    }
}
