@extends('layout.withoutAuthLayout')
@section('content')
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset ">
                        <div class="login-logo">
                            <img src="assets/img/logo.png" alt="img">
                        </div>

                        <div class="login-userheading">
                            {!! Session::get('qr_image') !!}
                        </div>
                        <div class="login-userheading">
                            <h3>Enter Verification Code</h3>
                        </div>
                        <form method="post" id='otpVerificationForm' action="{{ Route('post_otp_verify')}}">
                            @csrf
                            <div class="form-login">
                                <label>2FA Code </label>
                                <div class="form-addons">
                                    <input type="text" placeholder="Enter 2FA Code" name="otp" class="form-control">
                                </div>
                            </div>

                            <div class="form-login">
                                <button class="btn btn-login mb-1" type="submit" id="submit_form">Verify</button>
                                <button class="btn btn-login mb-1" type="button" id="loaderBtn" disabled style="display: none">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Verifying OTP...
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="login-img">
                    <img src="assets/img/login.jpg" alt="img">
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->
@endsection
