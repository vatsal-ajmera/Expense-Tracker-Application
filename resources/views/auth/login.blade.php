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
                        <h3>Sign In</h3>
                        <h4>Please login to your account</h4>
                    </div>

                    <form method="post" id='loginFormAdmin' action="{{ Route('auth.post_login')}}">
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
                            <label>Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input form-control" placeholder="Enter your password" name="password" class="form-control">
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                            <span id="error-password" class="invalid-feedback"></span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text">
                                <input type="checkbox" name="remember_me">
                            </span>
                            <span class="input-group-text">Remember me</span>
                        </div>
                        <div class="input-group">
                            <div class="form-login">
                                <div class="alreadyuser">
                                    <h4><a href="forgetpassword.html" class="hover-a">Forgot Password?</a></h4>
                                </div>
                            </div>
                        </div>

                        <div class="form-login">
                            <button class="btn btn-login mb-1" type="submit" id="login">Login</button>
                            <button class="btn btn-login mb-1" type="button" id="loaderBtn" disabled style="display: none">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>

                    <div class="signinform text-center">
                        <h4>Don’t have an account? <a href="signup.html" class="hover-a">Sign Up</a></h4>
                    </div>
                    <div class="form-setlogin">
                        <h4>Or sign up with</h4>
                    </div>
                    <div class="form-sociallink">
                        <ul>
                            <li>
                                <a href="javascript:void(0);">
                                    <img src="{{ url('assets/img/icons/google.png') }}" class="me-2" alt="google">
                                    Sign Up using Google
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <img src="{{ url('assets/img/icons/facebook.png') }}" class="me-2" alt="google">
                                    Sign Up using Facebook
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="login-img">
                <img src="{{ url('assets/img/login.jpg') }}" alt="img">
            </div>
        </div>
    </div>
@endsection
