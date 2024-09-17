<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.partials.head')
</head>

<body>
    @include('layout.partials.loader')
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        @if (!Route::is(['error-404', 'error-500', 'forgetpassword', 'resetpassword', 'signin', 'signup']))
            @include('layout.partials.header')
        @endif
        @if (!Route::is(['error-404', 'error-500', 'forgetpassword', 'pos', 'resetpassword', 'signin', 'signup']))
            @include('layout.partials.sidebar')
        @endif
        @yield('content')
    </div>
    <!-- /Main Wrapper -->
    @include('layout.partials.footer-scripts')
</body>

</html>
