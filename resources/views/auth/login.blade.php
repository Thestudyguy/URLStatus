<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Uptime Robot | MediaOnePH</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <script src="{{ asset('authScript/login.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
</head>

    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="" class="h1"><b>Uptime</b>Lubot</a> hahaha
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in</p>
                    <form action="../../index3.html" method="post">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-danger">Incorrect Credentials</div>
                        <div class="row">
                            <div class="col-8">
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-sm text-secondary">MediaOne PH</p>
        </div>
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            $(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                $('.swalDefaultSuccess').click(function() {
                    Toast.fire({
                        icon: 'success',
                        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
            });
        </script>
    </body>
</html>