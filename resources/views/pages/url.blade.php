<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">.
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}/">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <title>URL Status Checker</title>
</head>

<body>
    <div class="wrapper">
    @include('components.sidebar')
    <div class="content-wrapper p-5">
        <div id="accordion">
            URL History
            @foreach ($ladyBoy as $client_id => $urls)
                @php
                    $client = $urls->first();
                @endphp
                <div class="card">
                    <div class="card-header" id="heading{{ $client_id }}">
                        <h5 class="mb-0 d-flex justify-content-between align-items-center">
                            <button id="clientDetails-link-{{ $client_id }}"
                                    class="client-details-link btn btn-link" data-toggle="collapse"
                                    data-target="#collapse{{ $client_id }}" aria-expanded="true"
                                    aria-controls="collapse{{ $client_id }}">
                                {{ $client->client }}
                            </button>
                            <button hidden class="close-icon btn btn-transparent btn-sm"
                                    id="close-icon-{{ $client_id }}"
                                    onclick="toggleAccordion('#collapse{{ $client_id }}')">
                                <i class="fas fa-minus"></i>
                            </button>
                        </h5>
                    </div>

                    <div id="collapse{{ $client_id }}" class="collapse"
                         aria-labelledby="heading{{ $client_id }}" data-parent="#accordion">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>URL</th>
                                        <th>HTTP Codes</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($urls as $url)
                                    @php
                                        $status = $url->old_status;
                                        $statChar = substr($status, 0, 1);
                                    @endphp
                                    <tr>
                                            <td>{{ $url->url }}</td>
                                            @switch($statChar)
                                                @case($statChar == 1)
                                            <td><span class="badge text-bg-info">{{$url->old_status}}</span></td>
                                                    @break
                                                @case($statChar == 2)
                                            <td><span class="badge text-bg-success">{{$url->old_status}}</span></td>
                                                    @break
                                                @case($statChar == 3)
                                            <td><span class="badge text-bg-secondary">{{$url->old_status}}</span></td>
                                                    @break
                                                @case($statChar == 4)
                                            <td><span class="badge text-bg-warning">{{$url->old_status}}</span></td>
                                                    @break
                                                @case($statChar == 5)
                                            <td><span class="badge text-bg-danger">{{$url->old_status}}</span></td>
                                                    @break
                                                @default
                                            <td><span class="badge text-bg-dark">{{$url->old_status}}</span></td>
                                            @endswitch
                                            <td>{{ \Carbon\Carbon::parse($url->created_at)->format('F j, Y, g:i A') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script>
        var clientDetailsLinks = document.querySelectorAll('.client-details-link');
        clientDetailsLinks.forEach(function(clientDetailsLink) {
            var closeIcon = clientDetailsLink.nextElementSibling;
            clientDetailsLink.addEventListener('click', function() {
                closeIcon.hidden = !closeIcon.hidden;
            });
            closeIcon.addEventListener('click', function() {
                closeIcon.hidden = !closeIcon.hidden;
            });
        });
//
        function toggleAccordion(collapseId) {
            console.log('opened');
            var collapse = $(collapseId);
            collapse.collapse('toggle');
        }

    function clientDetails(id, client) {
        $("#urls_" + id).empty();
    }
    </script>
</body>

</html>
