<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Password Recovery | Food Distribution </title>
    <link rel="icon" type="image/x-icon" href="{{ asset('dash_resource/png/favicon.png') }}"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('fd_login/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('fd_login/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('fd_login/css/form-1.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('fd_login/css/theme-checkbox-radio.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fd_login/css/forms/switches.css')}}">
</head>
<body class="form">


    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h1 class="">Password Recovery</h1>
                        <p class="signup-link">Enter your email and instructions will sent to you!</p>
                        <form class="text-left" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form">

                                <div id="email-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                                    <input id="email" name="email" type="text" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">{{ __('Send Password Reset Link') }}</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <p class="terms-conditions">Copyright © <?php echo date('Y') ?> Powered by <a href="index.html">Whelson</a> IT.</p>

                    </div>
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image">
            </div>
        </div>
    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('fd_login/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('fd_login/js/popper.min.js')}}"></script>
    <script src="{{ asset('fd_login/js/bootstrap.min.js')}}"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('fd_login/js/form-1.js')}}"></script>

</body>
</html>
