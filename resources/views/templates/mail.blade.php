<html>
    <head>
        <link href="{{ asset('storage/styles/mail.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>
    </body>
    <footer>
        <p class="bold red">Michał 'Shpaq' Szpak</p>
        <p class="bold red"> Contact: shpaq23@gmail.com</p>
        <div class="social-media">
            <a href="https://github.com/shpaq23" target="_blank"><img src="{{asset('storage/logos/github.png')}}" alt="github" height="46"></a>
            <a href="https://www.linkedin.com/in/micha%C5%82-szpak-325463166/" target="_blank"><img src="{{asset('storage/logos/linkedin.png')}}" alt="linkedin" height="46"></a>
            <a href="https://www.facebook.com/profile.php?id=100001828697401" target="_blank"><img src="{{asset('storage/logos/facebook.png')}}" alt="facebook" height="46"></a>
        </div>
    </footer>
</html>