<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="NeumaTruck.cl es una de las principales comercializadoras de marcas líderes de neumáticos para camión y buses, y líneas pesadas. Importamos solo marcas innovadoras con productos de alta tecnología en la industria">
    <meta name="keywords"
        content=" neumaticos camion, neumaticos camion michelin, neumaticos camion pirelli, neumáticos camión dunlop, neumaticos camion linglong, neumaticos camion goodride, neumaticos camion triangle, neumaticos camion chaoyang, neumaticos camion sumitomo, neumaticos camion windforce,  neumaticos camion samson, neumaticos camion fesite, neumaticos camion chaoyang, neumaticos camion Golden Crown, neumaticos camion bridgestone, neumaticos direccion, neumaticos traccion, neumaticos camion carretera, neumaticos traccionales, neumáticos para carretera, neumaticos para faena, neumatico mixto, neumaticos de camion, neumaticos para camion, ruedas de camion, ruedas camion, neumaticos para camiones precios, Neumaticos camion baratos, ruedas de camion baratos, neumatico camion precio, venta de neumaticos para camiones, neumaticos de invierno para camion, neumaticos camion online, neumaticos de camiones nuevos, neumaticos para camiones precios, neumatico 11 r22.5, neumatico 295 80 r22.5, neumaticos 215 75 r17.5, neumaticos agricola, ruedas tractor, neumaticos de tractor, neumatico agricola precio, neumatico 12 r22.5, neumaticos macizos, neumaticos 17.5, neumaticos mineria, neumaticos para construccion, neumaticos 23.5, neumaticos cargador frontal, neumaticos motoniveladoras, neumatico para cargador, neumatico forestal, neumatico grua horquilla, neumaticos maquinaria pesada, neumatico 275 80 r22.5, neumáticos otr, neumatico pantanero, neumaticos de bus, neumaticos buses, neumático 255 70 r22.5, neumático industrial, neumático 12.00 r24, neumático 1200, 235 75 r17.5, 1200 r20, 315 80 r22.5,  750 75 r17.5">
    <meta name="google-site-verification" content="Si2YZwQ8s_-oWAcmJmbrZ2fNo4d0Myar0bTn7CCNr0Q">

    <title> NeumaTruck - Portada</title>

    <meta name="facebook-domain-verify" content="hmhiq76ah4inz05pdl0jgt08inex1h">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    {{-- <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script> --}}

    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/nouislider.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/style.css?ver=1.4') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/typeahead.css?ver=1.6') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-159179503-1"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('content-css')

    @livewireStyles

    @include("layouts.plugins")

    <!-- Google tag (gtag.js) --> 
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-10981964957">
    </script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-10981964957'); 
    </script> 


    @yield('finish-section-google')

</head>

<body>
    <a href="https://wa.me/{{ get_whatsapp() }}" class="whatsapp" target="_blank"> <i class="fa fa-whatsapp whatsapp-icon"></i></a>

    <div class="icon-bar text-center">
        <a target="_blank" style="background-color:#3b5998;" href="{{ facebook() }}" class="facebook"><i class="fa fa-facebook"></i></a>
        <a target="_blank" style="background-color:blue;" href="tel:{{ phone_main() }}" class="google"><i class="fa fa-phone"></i></a>
        <a target="_blank" style="background:linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);" href="{{ instagram() }}" class="youtube"><i class="fa fa-instagram"></i></a>
    </div>


    <header>

        <!-- TOP HEADER -->
        <div id="top-header">
            <div id="div-interno-header" class="container" style="display:flex;justify-content:center">
                <ul class="header-links pull-left">
                    <li><a id="tel-text-fono" class="ul-telefonos" href="#">Fono ventas:</a></li>
                    <li><a id="tel-max-firts" class="ul-telefonos" href="tel:{{ phone_main() }}"><i class="fa fa-phone"></i>{{ phone_main() }}</a></li>
                </ul>
            </div>

            <div class="container" style="display:flex;justify-content:center">
                <ul class="header-links pull-left">
                    <li><a id="mail-min" href="mailto:contacto@neumatruck.cl"><i class="fa fa-envelope-o"></i>contacto@neumatruck.cl</a></li>
                    {{-- <li><a id="horario-min" href="javascript:void(0);"><i class="fa fa-clock-o"></i>Lunes a Viernes: 09:00 a 18:00 hrs</a></li> --}}
                    <li><a id="horario-min" href="javascript:void(0);">
                        <i class="fa fa-clock-o"></i>Retiro en tienda de lunes a viernes: 11:00 a 17:00 hrs</a>
                    </li>
                </ul>
            </div>
        </div>

        <div id="header">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-4">
                        <div class="header-logo">
                            <a href="{{ url("./") }}" class="logo">
                                <img class="img-logo" src="{{ asset('assets/img/logo.png') }}" alt="NeumaTruck"
                                    style="width:300px;">
                            </a>
                        </div>
                    </div>
                    <!-- /LOGO -->
                    <!-- SEARCH BAR -->
                    <div class="col-md-7">
                        <div class="header-search">
                            <form name="buscador-principal" autocomplete="off">
                                <div class="autocompletar text-center">
                                    <input id="tipo-busqueda" class="input" name="tipo-item" placeholder="Busca tu Medida" required="">
                                    <button id="btn-search" class="search-btn" type="submit">Buscar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /SEARCH BAR -->
                    <!-- ACCOUNT -->
                    <div class="col-md-1 clearfix">
                        <div class="header-ctn cton-carrito">
                            <!-- Cart -->
                            @livewire("icon-carrito")

                        </div>
                        <!-- <i class="fa fa-shopping-cart"></i> -->
                    </div>
                    <!-- /ACCOUNT -->
                </div>
                <style>
                    #header {
                        padding-bottom: 0px;
                    }

                    .navbar {
                        border-radius: 0px;
                    }

                    .navbar-default .container-fluid {
                        padding-left: 0px;
                    }

                    .navbar-default .navbar-nav {
                        padding-left: 0px;
                    }

                    .navbar-collapse {
                        padding-left: 0px;
                    }

                    .nav>li>a {
                        /*padding-left: 0px;
  padding-right: 0px;*/
                    }

                    .navbar-default .navbar-nav>li>a {
                        color: #e5e5e5;
                        text-transform: uppercase;
                    }

                    .navbar-default .navbar-nav>li>a:hover {
                        color: #fff;
                    }

                    .navbar-default .navbar-nav>li>a:active {
                        color: #fff;
                    }

                    .navbar-nav>li {
                        float: none;
                    }

                    @media (min-width: 768px) {
                        .nav-justified>li {
                            display: table-cell;
                            width: 1%;
                        }
                    }
                </style>
                <!-- NAVEGADOR TOBLE -->
                <div class="col-md-3 clearfix">

                    @livewire("icon-carrito-responsive")

                </div>
                
                @include('includes.nav-responsive')

                @include('includes.nav-desktop')
            </div>
            <!-- container -->
        </div>
    </header>


    @yield('content-general')

    @livewire("newslatter")

    <footer id="footer">
        <div class="section">
            <div class="container">
                <div class="col-md-3 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">Nosotros</h3>
                        <p class="text-justify">
                            NeumaTruck.cl es una de las principales comercializadoras de marcas líderes de neumáticos
                            para camión y buses, y líneas pesadas. Importamos solo marcas innovadoras con productos de
                            alta tecnología en la industria.
                            Stock sujeto a cambios sin previo aviso
                        </p>
                        <ul class="footer-links">
                            <li><a href="{{ url('/politicas-despacho') }}"><i class="fa fa-truck"></i> Politicas de Despacho</a></li>
                            <li><a href="{{ url('/politicas-devolucion') }}"><i class="fa fa-truck"></i> Politicas de Devolución</a>
                                <li><a href="{{ url('/app/politias-privacidad') }}"><i class="fa fa-truck"></i> Politicas de Privacidad</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-2 col-xs-6 col-md-offset-1">
                    <div class="footer">
                        <h3 class="footer-title">Categorías</h3>
                        <ul class="footer-links">
                            @foreach (get_categoria_footer() as $item )
                            <li><a href="{{ url('./categoria').'/'.base64_encode($item->id) }}" >{{ strtoupper($item->nombre) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="clearfix visible-xs"></div>
                <div class="col-md-2 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">Marcas</h3>
                        <ul class="footer-links">
                            @foreach (get_marcas_footer() as $item )
                            <li><a href="{{ url("./category-brand").'/'.$item->id_marca }}">{{ strtoupper($item->marca) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">Contacto</h3>
                        <ul class="footer-links">
                            <ul class="footer-links">
                                <li><a href="assets/contacto.php"><i class="fa fa-map-marker"></i>Santa Margarita 0448 - San bernardo - Rm</a></li>
                                @foreach (get_phones() as $item )
                                <li><a href="tel:{{ $item->telefono }}"><i class="fa fa-phone"></i>{{ $item->telefono }}</a></li>
                                @endforeach
                                <li><a href="mailto:contacto@neumatruck.cl"><i class="fa fa-envelope-o"></i>contacto@neumatruck.cl</a></li>
                                {{-- <li><a href="javascript:void(0);"><i class="fa fa-clock-o"></i>Lunes a Viernes: 09:00 a 18:00 hrs</a></li> --}}
                                <li><a href="javascript:void(0);"><i class="fa fa-clock-o"></i>Retiro en tienda de Lunes a Viernes: 11:00 a 17:00 hrs</a></li>
                            </ul>
                        </ul>
                    </div>

                </div>

            </div>

            <!-- /row -->

        </div>

        <div id="bottom-footer" class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <ul class="footer-payments">
                            <div class="col-md-3">
                                <div class="header-logo">
                                    <a href="assets/" class="logo">
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="Neumatruck"
                                            style="width:300px;">
                                    </a>
                                    <br class="visible-xs"><br class="visible-xs"><br class="visible-xs">
                                </div>
                            </div>
                        </ul>
                    </div>
                    <div class="col-md-4 text-center">



                    </div>
                    <div class="col-md-4 text-center">
                        <ul class="footer-payments">
                            <div class="col-md-3">
                                <div class="header-logo">
                                    <a href="assets/" class="logo">
                                        <img style="margin-top:20px;" src="{{ asset('assets/img/pgo.png') }}" alt="Neumatruck">
                                    </a>
                                    <br class="visible-xs"><br class="visible-xs"><br class="visible-xs">
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @livewire("popup")

    <!-- /FOOTER modal -->

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var _Url = "{{ url('/') }}/";
        let validador_email = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/
        // $("#exampleModal").modal("show");
        $('#exampleModalCenter').modal("show");
    </script>
    <script src="{{ asset('assets/js/search.js') }}"></script>
    <script src="{{ asset('assets/js/selector.js') }}"></script>



    {{-- <script type="text/javascript" id="zsiqchat">var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode: "90872474c6e22cee5d486a671662c849675c91e4c2dc01163e9240e46248b799", values:{},ready:function(){}};var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;s.src="https://salesiq.zoho.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);</script> --}}
    @stack("scripts")

    @yield('content-script')
    @livewireScripts

    </body>
</html>
