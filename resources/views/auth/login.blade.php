<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Login | Food Distribution </title>
    <link rel="icon" type="image/x-icon" href="{{ asset('dash_resource/png/favicon.png') }}"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('fd_login/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('fd_login/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('fd_login/css/form-1.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('fd_login/css/theme-checkbox-radio.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fd_login/css/switches.css')}}">
</head>
<body class="form">


    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Food <a href="{{ url('/home')}}"><span class="brand-name">Distribution</span></a></h1>

                        <form class="text-left" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form">

                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="username" name="login" type="text" class="form-control {{ $errors->has('paynumber') ? ' is-invalid' : '' }}" placeholder="Paynumber" >

                                    @if ($errors->has('paynumber'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('paynumber') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Show Password</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" id="toggle-password" class="d-none">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Log In</button>
                                    </div>

                                </div>

                                <div class="field-wrapper text-center keep-logged-in">
                                    <div class="n-chk new-checkbox checkbox-outline-primary">
                                        <label class="new-control new-checkbox checkbox-outline-primary">
                                          <input type="checkbox" class="new-control-input">
                                          <span class="new-control-indicator"></span>Remember me
                                        </label>
                                    </div>
                                </div>

                                <div class="field-wrapper">
                                    @if(Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="forgot-pass-link">Forgot Password?</a>
                                    @endif
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
