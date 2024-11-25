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
    


    


    @yield('content-general')

    @livewire("newslatter")

    

    @livewire("popup")

    

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
