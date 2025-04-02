<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\Email;
use App\Mail\sendResetPasswordMail;
use App\Models\passwordReset;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use Session;
use Str;

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
        return view('auth.login', ['meta_data' => $this->meta_data]);
    }

    public function post_login(Request $request)
    {
        $remember_me = $request->only('remember_me') ? TRUE : FALSE;
        $auth = auth()->guard($this->gaurd);
        if ($auth->attempt($request->only('email', 'password'), $remember_me)) :
            $user = $auth->user();

            if (empty($user->google2fa_secret) and $user->auth_verified == FALSE && $user->two_fa_varications == true) {
                $user->google2fa_secret = $this->google2fa->generateSecretKey();
                $user->save();

                $qr_image = $this->google2fa->getQRCodeInline(
                    'AIR POS APP',
                    $user->email,
                    $user->google2fa_secret
                );
                Session::put('qr_image', $qr_image);
            }
            session::put('locale',  Config::get('app.locale'));
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
        $auth = auth()->guard($this->gaurd);
        $user = $auth->user();
        if (empty($user->google2fa_secret) and $user->auth_verified == FALSE && $user->two_fa_varications == true) {
            $user->google2fa_secret = $this->google2fa->generateSecretKey();
            $user->save();

            $qr_image = $this->google2fa->getQRCodeInline(
                'Air Expense APP',
                $user->email,
                $user->google2fa_secret
            );
            Session::put('qr_image', $qr_image);
        }
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

    public function forgot_password(Request $request) {
        if ($request->isMethod('GET')) {
            $this->meta_data = [
                'title' => 'Forgot Password',
                'description' => 'Forgot Password',
                'keywords' => 'Forgot Password',
            ];
            return view('auth.forgot-password', ['meta_data' => $this->meta_data]);
        }elseif ($request->isMethod('POST')){
            $request->validate([
                'email' => 'required|email|exists:users',
            ]);

            $token = Str::random(64);
            $recovery_token = str_replace('/', '-', $token);

            passwordReset::updateOrCreate(
                ['email' => $request->email],
                ['email' => $request->email, 'token' => $recovery_token, 'created_at' => Carbon::now()]
            );
            Session::put('password_reset_link_set', 'We have e-mailed your password reset link!');

            Email::dispatch([$request->email], new sendResetPasswordMail($recovery_token));
            $data = [
                'redirect' => route('auth.login')
            ];
            return $this->send_response($data, '');
        }
    }

    public function showResetPasswordForm($token)
    {
        $updatePassword = passwordReset::where('token', $token)->first();
        if(!$updatePassword){
            abort(404);
        }
        $this->meta_data = [
            'title' => 'Reset Password',
            'description' => 'Reset Password',
            'keywords' => 'Reset Password',
        ];
        $data = [
            'token' => $token,
            'email' => $updatePassword->email
        ];
        return view('auth.reset-password', ['meta_data' => $this->meta_data, 'data' => $data]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password'
        ]);

        $is_update_passeord = User::where('email', $request->email)
                    ->update(['password' => Hash::make($request->password)]);
        if ($is_update_passeord) {
            $data = [
                'redirect' => route('auth.login')
            ];
            passwordReset::where(['email'=> $request->email])->delete();
            Session::put('password_reset', 'Password Reset Successfully');
            return $this->send_response($data, '');
        }
        
    }

    public function logout()
    {
        $auth = auth()->guard($this->gaurd);
        $auth->logout();
        Session::flush();
        return redirect('login')->with(['success' => 'Logged Out']);
    }
}
