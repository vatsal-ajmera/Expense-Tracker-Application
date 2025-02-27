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
                        <h3>Forgot password?</h3>
                        <h4>Don’t warry! it happens. Please enter the address <br>
                            associated with your account.</h4>
                    </div>

                    <form method="post" id='forgotPasswordForm' action="{{ Route('auth.forgot_password.post')}}">
                        @csrf
                        <div class="form-login">
                            <label>Email</label>
                            <div class="form-addons">
                                <input type="text" placeholder="Enter your email address" name="email" class="form-control">
                                <img src="{{ url('assets/img/icons/mail.svg') }}" alt="img">
                            </div>
                            <span id="error-email" class="invalid-feedback"></span>
                        </div>

                        <div class="form-login">
                            <button class="btn btn-login mb-1" type="submit" id="login">Verify</button>
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
