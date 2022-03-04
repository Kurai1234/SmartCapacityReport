@include('layouts.header')

<body>

    @include('layouts.sidebar')
    <div class="main--content--holder">
        @yield('content')
    </div>








    @include('layouts.footer')

</body>
