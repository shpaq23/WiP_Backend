<html>
    <head>
        <style>
            p {
                margin: 4px 0;
            }
            .bold {
                font-weight: bold;
            }
            .red {
                color: red;
            }
            .social-media {
                margin-top: 10px;
            }
            body {
                text-align: center;
                background: #d2d7dc;
            }
            .top {
                font-size: larger;
                margin: 5%;
            }
            .portal {
                text-align: left;
            }
            .container {
                max-width: 640px;
                display: inline-block;
                text-align: center;
                border: 4px solid #03A9F4;
                border-radius: 10px;
                padding: 10px;
                background-color: aliceblue;
            }
            h1, h2 {
                text-align: center;
                border-bottom: 4px solid #03A9F4;
            }
            a.button {
                color: aliceblue;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                padding-left: 25px;
                padding-right: 25px;
                background-clip: padding-box;
                height: 36px;
                line-height: 36px;
                background-color: #3d616c;
                border-radius: 10px;
            }
            table {
                background: #d2d7dc;
            }
        </style>
    </head>
    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr width="100%" height="50" style="border-collapse:collapse"></tr>
            <tr>
                <td align="center">
                    <div class="container">
                        @yield('content')
                    </div>
                    <footer>
                        <p class="bold red">Michał 'Shpaq' Szpak</p>
                        <p class="bold red"> Contact: shpaq23@gmail.com</p>
                        <div class="social-media">
                            <a href="https://github.com/shpaq23" target="_blank"><img src="{{$logoUrl.'/github'}}" alt="github" height="46"></a>
                            <a href="https://www.linkedin.com/in/micha%C5%82-szpak-325463166/" target="_blank"><img src="{{$logoUrl.'/linkedin'}}" alt="linkedin" height="46"></a>
                            <a href="https://www.facebook.com/profile.php?id=100001828697401" target="_blank"><img src="{{$logoUrl.'/facebook'}}" alt="facebook" height="46"></a>
                        </div>
                    </footer>
                </td>
            </tr>
        </table>
    </body>
</html>