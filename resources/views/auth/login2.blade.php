<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Login | Food Humber Distribution </title>
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon.ico')}}"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('as_login/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('as_login/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('as_login/assets/css/authentication/form-1.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('as_login/assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('as_login/assets/css/forms/switches.css') }}">
</head>

<style>
    .fixed {
  position: fixed;
  bottom: 2%;
  left: 15%;
  width: 300px;
}
</style>
<body class="form">


<div class="form-container">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                    <h1 style="font-size:26px;" class=""><span class="brand-name"> Whelson Food Distribution</span></h1>

                    <form class="text-left" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form">

                            <div id="username-field" class="field-wrapper input">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>

                                <input id="paynumber" type="text" class="form-control{{ $errors->has('paynumber') ? ' is-invalid' : '' }}" name="login" value="{{ old('paynumber') }}" required autofocus placeholder="{{ __('Pay Number') }}" autocomplete="paynumber">

                                @if ($errors->has('paynumber'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('paynumber') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div id="password-field" class="field-wrapper input mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

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

                            <div class="field-wrapper">
                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-pass-link">Forgot Password?</a>
                                @endif
                            </div>

                        </div>
                    </form>
                    <p class=" fixed terms-conditions"> Whelson IT © <?php echo date('Y'); ?> All Rights Reserved.</p>

                </div>
            </div>
        </div>
    </div>
    <div class="form-image">
        <div class="l-image">
        </div>
    </div>
</div>
<script src=" {{ asset('as_login/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('as_login/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('as_login/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('as_login/assets/js/authentication/form-1.js') }} "></script>

</body>
</html>
