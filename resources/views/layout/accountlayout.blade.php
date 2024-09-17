<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.partials.head')
</head>
    @if (Route::is(['error-404', 'error-500']))
        <body class="error-page">
    @else
        <body class="account-page">
    @endif
    @include('layout.partials.loader')
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        @yield('content')
    </div>
    <!-- /Main Wrapper -->
    @include('layout.partials.footer-scripts')
</body>

</html>
