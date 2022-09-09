<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>
        @if (trim($__env->yieldContent('template_title')))
            @yield('template_title') |
        @endif {{ config('app.name', Lang::get('titles.app')) }}
    </title>
    <meta charset="utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="Vincent Marufu" />

    @yield('template_linked_css')

    <link rel="icon" href="{{ asset('dash_resource/png/favicon.png') }}" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800"--}} rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700"--}} rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"
        integrity="sha512-xIPqqrfvUAc/Cspuj7Bq0UtHNo/5qkdyngx6Vwt+tmbvTLDszzXM0G6c91LXmGrRx8KEPulT+AfOOez+TeVylg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/bootstrap.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('dash_resource/css/waves.min.css') }}" type="text/css" media="all" />

    <link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/feather.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/font-awesome-n.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/font-awesome.min.css') }}" />


    <link rel="stylesheet" href="{{ asset('dash_resource/css/chartist.css') }}" type="text/css" media="all" />

    <link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/widget.css') }}" />
</head>

<body>
    <div class="loader-bg">
        <div class="loader-bar"></div>
    </div>

    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            @include('partials.header')

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    @include('partials.sidebar')

                    <div class="pcoded-content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <script type="text/javascript" src="{{ asset('dash_resource/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dash_resource/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dash_resource/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dash_resource/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('dash_resource/js/waves.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript" src="{{ asset('dash_resource/js/jquery.slimscroll.js') }}"></script>

    <script src="{{ asset('dash_resource/js/jquery.flot.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/jquery.flot.categories.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/curvedlines.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/jquery.flot.tooltip.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('dash_resource/js/amcharts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/serial.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/light.js') }}" type="text/javascript"></script>

    <script src="{{ asset('dash_resource/js/markerclusterer.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="{{ asset('dash_resource/js/gmaps.js') }}"></script>

    <script src="{{ asset('dash_resource/js/pcoded.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dash_resource/js/vertical-layout.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('dash_resource/js/crm-dashboard.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dash_resource/js/script.min.js') }}"></script>

    @yield('footer_scripts')

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" type="text/javascript"></script>
    <script type="text/javascript">
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
    <script src="{{ asset('dash_resource/js/rocket-loader.min.js') }}" data-cf-settings="49" defer=""></script>
</body>

</html>
