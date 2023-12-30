@stack('before-style')
@include('includes.style')
@stack('after-style')

<!DOCTYPE html>
<html lang="en">
<body>
    @include('includes.header')
    
    @include('includes.sidebar')
    <main id="main" class="main">
        @yield('content')
    </main>
    @include('includes.footer')
    
   

    @stack('before-script')
    @include('includes.script')
    @stack('after-script')

</body>
</html>