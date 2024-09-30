<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Response;
use Session;

class AuthController extends Controller
{
    private $redirect_after_login;
    private $gaurd;
    public $meta_data;
    public $google2fa;
    public function __construct()
    {

        $this->redirect_after_login = '/dashboard';
        $this->gaurd = view()->shared('auth_gaurd');
        $this->meta_data = [
            'title' => 'Admin Login',
            'description' => 'Admin login ',
            'keywords' => 'Login to Admin Dashboard',
        ];
        $this->google2fa = app('pragmarx.google2fa');
    }
    public function login()
    {
        if (auth()->guard($this->gaurd)->check()) :
            return redirect($this->redirect_after_login);
        endif;
        return view('auth/login', ['meta_data' => $this->meta_data]);
    }

    public function post_login(Request $request)
    {
        $remember_me = $request->only('remember_me') ? TRUE : FALSE;
        $auth = auth()->guard($this->gaurd);
        if ($auth->attempt($request->only('email', 'password'), $remember_me)) :
            $user = $auth->user();

            if (empty($user->google2fa_secret) and $user->auth_verified == FALSE) {
                $user->google2fa_secret = $this->google2fa->generateSecretKey();
                $user->save();

                $qr_image = $this->google2fa->getQRCodeInline(
                    'AIR POS APP',
                    $user->email,
                    $user->google2fa_secret
                );
                Session::put('qr_image', $qr_image);
            }

            $data = [
                'redirect' => route('dashboard')
            ];
            return $this->send_response($data, 'Successfully Logged');
        else :
            return $this->send_error_response([], 'Provided Credentials is invalid', 200);
        endif;
    }
    public function authenticate_user()
    {
        $this->meta_data = [
            'title' => '2 FA Authentication',
            'description' => '2 FA Authentication',
            'keywords' => '2 FA Authentication',
        ];
        return view('google2fa.index', ['meta_data' => $this->meta_data]);
    }
    public function post_authenticate_user(Request $request)
    {
        $user = auth()->guard($this->gaurd)->user();

        if ($this->google2fa->verifyKey($user->google2fa_secret, $request->input('otp'))) {
            $request->session()->put('2fa_verified', TRUE);

            $user->auth_verified = User::AUTH_VERIFIED;
            $user->save();
            if (Session::get('qr_image')) {
                Session::forget('qr_image');
            }

            $data = [
                'redirect' => route('dashboard'),
            ];
            return $this->send_response($data, 'User Authentication Successful');
        }

        return $this->send_error_response([], 'Provided OTP is invalid', 200);
    }

    public function logout()
    {
        $auth = auth()->guard($this->gaurd);
        $auth->logout();
        Session::flush();
        return redirect('login')->with(['success' => 'Logged Out']);
    }
}
