@extends('layout.withoutAuthLayout')
@section('content')
    <div class="account-content">
        <div class="login-wrapper">
            <div class="login-content">
                <div class="login-userset">
                    <div class="login-logo logo-normal">
                        <img src="{{ url('assets/img/logo.png') }}" alt="img">
                    </div>
                    <a href="index.html" class="login-logo logo-white">
                        <img src="{{ url('assets/img/logo-white.png') }}" alt="">
                    </a>
                    <div class="login-userheading">
                        <h3>Reset Password</h3>
                    </div>

                    <form method="post" id='resetPasswordForm' action="{{ Route('auth.reset.password.post')}}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $data['token'] }}">
                        <input type="hidden" name="email" value="{{ $data['email'] }}">
                        <div class="form-login">
                            <label>Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input" placeholder="Enter your password" name="password" id="password">
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                            <span id="error-password" class="invalid-feedback"></span>
                        </div>
                        <div class="form-login">
                            <label>Confirm Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-inputs" placeholder="Enter confirm password" name="confirm_password" id="confirm_password">
                                <span class="fas toggle-passwords fa-eye-slash"></span>
                            </div>
                            <span id="error-confirm-password" class="invalid-feedback"></span>
                        </div>

                        <div class="form-login">
                            <button class="btn btn-login mb-1" type="submit" id="submit_form">Reset Password</button>
                            <button class="btn btn-login mb-1" type="button" id="loaderBtn" disabled style="display: none">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="login-img">
                <img src="{{ url('assets/img/login.jpg') }}" alt="img">
            </div>
        </div>
    </div>
@endsection
