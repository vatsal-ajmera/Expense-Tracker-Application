<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.partials.head')
</head>

<body>
    @include('layout.partials.loader')
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        @include('layout.partials.header')

        @include('layout.partials.sidebar')
        
        @yield('content')
    </div>
    <!-- /Main Wrapper -->
    @include('layout.partials.footer-scripts')
</body>

</html>
