<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" @if (config('voyager.multilingual.rtl')) dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="none"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="admin login">
    <title>Admin - {{ Voyager::setting("admin.title") }}</title>
    <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">
    @if (config('voyager.multilingual.rtl'))
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="{{ voyager_asset('css/rtl.css') }}">
    @endif
    <style>
        body {

            background-color: {{ Voyager::setting("admin.bg_color", "#FFFFFF" ) }};
        }

        body.login .login-sidebar {
            border-top: 5px solid{{ config('voyager.primary_color','#22A7F0') }};
        }

        @media (max-width: 767px) {
            body.login .login-sidebar {
                border-top: 0px !important;
                border-left: 5px solid{{ config('voyager.primary_color','#22A7F0') }};
            }
        }

        body.login .form-group-default.focused {
            border-color: {{ config('voyager.primary_color','#22A7F0') }};
        }

        .login-button, .bar:before, .bar:after {
            background: {{ config('voyager.primary_color','#22A7F0') }};
        }

        {{--
         body.login .logo-title-container {
            margin-top: 0;
            bottom: 42%;
            left: 25%;
        }

        @media (max-width: 790px) {
            body.login .logo-title-container {
                bottom: 42%;
                left: 5%;
            }
        }

        body.login .logo {
            height: auto;
            max-width: 156px;
            margin: 0 auto;
            padding-top: 0;
            padding-bottom: 0;
            margin-left: 92px;
            margin-bottom: 1em;
        }

        body.login .copy {
            width: auto;
            padding: 0;
        }
        --}}
.logo {
            height: 156px !important;
            max-width: 156px !important;
            padding: 0 !important;
        }

        body.login .faded-bg {
            background: none;
            background-color: {{Voyager::setting("admin.bg_color", "rgb(168,207,81)" )}};
        {{--
        background: linear-gradient(to bottom, rgba(21, 21, 28, 0) 0, rgba(21, 21, 28, .1) 40%, rgba(21, 21, 28, .3) 55%, rgba(21, 21, 28, .61) 75%, #15151c 100%);
        filter:
        progid: DXImageTransform . Microsoft . gradient(startColorstr = '#0015151c', endColorstr = '#15151c', GradientType = 0);
        --}}

























        }
    </style>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
</head>
<body class="login">
<div class="container-fluid">
    <div class="row">
        <div class="faded-bg animated"></div>
        <div class="hidden-xs col-sm-7 col-md-8" style="margin-top: 40vh;">


            <div class="row" style="display: flex; justify-content: center">
                <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                @if($admin_logo_img == '')
                    <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn"
                         src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="Logo Icon">
                @else
                    <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn"
                         src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                @endif
            </div>
            <div class="animated fadeIn row" style="text-align: center">
                {{-- <h1>{{ Voyager::setting('admin.title', 'Voyager') }}</h1>--}}
                <p style="color: white;margin-top: 1.4em;">{{ Voyager::setting('admin.description', __('voyager::login.welcome')) }}</p>
            </div>


        </div>

        <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">

            <div class="login-container">

                <p>{{ __('voyager::login.signin_below') }}</p>

                <form action="{{ route('voyager.login') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group form-group-default" id="emailGroup">
                        <label>{{ __('voyager::generic.email') }}</label>
                        <div class="controls">
                            <input type="text" name="email" id="email" value="{{ old('email') }}"
                                   placeholder="{{ __('voyager::generic.email') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group form-group-default" id="passwordGroup">
                        <label>{{ __('voyager::generic.password') }}</label>
                        <div class="controls">
                            <input type="password" name="password" placeholder="{{ __('voyager::generic.password') }}"
                                   class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-block login-button">
                        <span class="signingin hidden"><span
                                    class="voyager-refresh"></span> {{ __('voyager::login.loggingin') }}...</span>
                        <span class="signin">{{ __('voyager::generic.login') }}</span>
                    </button>

                </form>

                <div style="clear:both"></div>

                @if(!$errors->isEmpty())
                    <div class="alert alert-red">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div> <!-- .login-container -->

        </div> <!-- .login-sidebar -->
    </div> <!-- .row -->
</div> <!-- .container-fluid -->
<script>
    var btn = document.querySelector('button[type="submit"]');
    var form = document.forms[0];
    var email = document.querySelector('[name="email"]');
    var password = document.querySelector('[name="password"]');
    btn.addEventListener('click', function (ev) {
        if (form.checkValidity()) {
            btn.querySelector('.signingin').className = 'signingin';
            btn.querySelector('.signin').className = 'signin hidden';
        } else {
            ev.preventDefault();
        }
    });
    email.focus();
    document.getElementById('emailGroup').classList.add("focused");

    // Focus events for email and password fields
    email.addEventListener('focusin', function (e) {
        document.getElementById('emailGroup').classList.add("focused");
    });
    email.addEventListener('focusout', function (e) {
        document.getElementById('emailGroup').classList.remove("focused");
    });

    password.addEventListener('focusin', function (e) {
        document.getElementById('passwordGroup').classList.add("focused");
    });
    password.addEventListener('focusout', function (e) {
        document.getElementById('passwordGroup').classList.remove("focused");
    });

</script>
</body>
</html>
