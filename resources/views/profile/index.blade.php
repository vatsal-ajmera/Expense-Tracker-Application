@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>{{ $meta_data['title'] }}</h4>
                    <h6>{{ $meta_data['description'] }}</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="profile-set">
                        <div class="profile-head">

                        </div>
                        <form method="post" id='updateAvatarForm' action="{{ Route('profile.avatar.post')}}">
                            <div class="profile-top">
                                <div class="profile-content">
                                    <div class="profile-contentimg">
                                        @if (!empty($auth_user->avatar))                                    
                                            <img src="{{ asset('storage/uploads/profile').'/' . $auth_user->avatar }}" alt="img" id="blah">
                                        @else    
                                            <img src="{{ asset('/assets/img/customer/customer5.jpg') }}" alt="img" id="blah">
                                        @endif
                                        <div class="profileupload">
                                            <input type="file" name='avatar' id="avatar"><a href="javascript:void(0);" >
                                            <img src="{{ asset('/assets/img/icons/edit-set.svg') }}"  alt="img"></a>
                                        </div>
                                    </div>
                                    <div class="profile-contentname">
                                        <h2>{{ $auth_user->name }} {{ $auth_user->last_name }}</h2>
                                        <h4>Updates Your Photo and Personal Details.</h4>
                                        <div id="avatarErrorContainer"></div>
                                    </div>
                                </div>
                                <div class="ms-auto">
                                    <button class="btn btn-submit me-2" id="submit_form" type="submit">save</button>
                                    <button class="btn btn-submit me-2" type="button" id="loaderBtn" disabled style="display: none">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <form method="post" id='updateProfileForm' action="{{ Route('profile.post')}}">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="name" value="{{ $auth_user->name }}" placeholder="Your name">
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" value="{{ $auth_user->last_name }}" placeholder="Your last name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" value="{{ $auth_user->email }}" placeholder="admin@test.com">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" value="{{ $auth_user->phone }}" placeholder="+91 1234567890">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input type="text" value="{{ $auth_user->email }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="pass-group">
                                        <input type="password" name="password" id="password" class=" pass-input">
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <div class="pass-group">
                                        <input type="password" name="confirm_password" class="pass-input">
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-submit me-2" id="submit_form" type="submit">save</button>
                                <button class="btn btn-submit me-2" type="button" id="loaderBtn" disabled style="display: none">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#blah").attr("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#avatar").change(function () {
        readURL(this);
    });
    </script>
@endsection
