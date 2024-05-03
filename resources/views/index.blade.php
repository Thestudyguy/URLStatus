<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('main.js') }}" defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <title>URL Status Checker</title>
</head>

<body style="max-height: 100vh;">
    <div class="container mt-4">

        <div hidden class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            URL removed successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div hidden class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
            <strong>Oops!</strong> Something went wrong. <br>
            <div class="lead" style="font-size: 14px;">if issue persist try reloading the page.</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>


        <div class="card">
            <div class="card-header">
                <div class="input-group">
                    <select name="" id="filterStatus" class="form-control">
                        <option value="" disabled selected hidden id="default">Filter URL Status</option>
                    </select>
                    <button class="btn btn-secondary" id="clear-filter">Clear</button>
                </div>
                {{-- <input type="text" class="form-control mt-1" placeholder="search..." name="search" id="search"> --}}
            </div>
            <div class="card-body" style="overflow-y:auto; overflow-x:hidden; height:300px;">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>URL</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @include('table')
                        <div class="spinner-border text-secondary" role="status" id="loadingIndicatorTable"
                            style="display: none; align-items: center; justify-content: center; font-size: 12px; width: 1.5rem; height: 1.5rem; border-width: 0.35em; position: relative; left:50%; top:50%;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" data-toggle="modal" data-target="#urlemailModal" id="addNew">Add
                    New</button>
                @include('modal')
                @include('email')
                @include('url_email')
            </div>
        </div>
        <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="overflow: auto;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Added URL</h5>
                    </div>
                    <div class="modal-body">
                        <div class="" id="url_info">
                            <div class="" id="url_status"></div>
                            <div class="" id="url_text"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <p class="text-secondary" style="font-size: 12px">click anywhere to dismiss</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
</body>

</html>
