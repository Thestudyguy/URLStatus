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
                    </tbody>

                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" data-toggle="modal" data-target="#urlemailModal">Add New</button>
                @include('modal')
                @include('email')
                @include('url_email')
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

    <script>
        const statuscode = {
            100: 'Continue',
            101: 'Switching Protocols',
            200: 'OK',
            201: 'Created',
            202: 'Accepted',
            203: 'Non-Authoritative Information',
            204: 'No Content',
            205: 'Reset Content',
            206: 'Partial Content',
            300: 'Multiple Choices',
            301: 'Moved Permanently',
            302: 'Found',
            303: 'See Other',
            304: 'Not Modified',
            305: 'Use Proxy',
            307: 'Temporary Redirect',
            400: 'Bad Request',
            401: 'Unauthorized',
            402: 'Payment Required',
            403: 'Forbidden',
            404: 'Not Found',
            405: 'Method Not Allowed',
            406: 'Not Acceptable',
            407: 'Proxy Authentication Required',
            408: 'Request Timeout',
            409: 'Conflict',
            410: 'Gone',
            411: 'Length Required',
            412: 'Precondition Failed',
            413: 'Request Entity Too Large',
            414: 'Request-URI Too Long',
            415: 'Unsupported Media Type',
            416: 'Requested Range Not Satisfiable',
            417: 'Expectation Failed',
            500: 'Internal Server Error',
            501: 'Not Implemented',
            502: 'Bad Gateway',
            503: 'Service Unavailable',
            504: 'Gateway Timeout',
            505: 'HTTP Version Not Supported',
            525: 'SSL Handshake Failed'
        };
        
        function getEmail(id, url){
            var token = $('meta[name="csrf-token"]').attr("content");
            $("#title").text(url);
            $.ajax({
                url: 'get-email/'+id,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                datatype: 'json/application',
                success: function(data){
                    var email = data.res;
                    email.forEach(emails => {
                        
                    });
                },
                error: function(error){
                    console.log(error);
                }
            })
        }
       
        $(document).ready(function() {
            var emailInputCounter = 0;
            $("#addEmailInput").click(function() {
                emailInputCounter++;
                var emailInputHtml =
                    '<div class="input-group mt-2 emailInputWrapper" id="emailInputGroup_' +
                    emailInputCounter + '">' +
                    '<input type="email" class="form-control emailInput" placeholder="Enter Email" name="email[]" required>' +
                    '<button class="btn btn-outline-danger" type="button" onclick="removeEmailInput(' +
                    emailInputCounter + ')">Remove</button>' +
                    '</div>';
                $("#emailInputs").append(emailInputHtml);
                $("#emailInputGroup_" + emailInputCounter).hide().slideDown();
            });
            window.removeEmailInput = function(inputId) {
                $("#emailInputGroup_" + inputId).fadeOut(function() {
                    $(this).remove();
                });
            };
            window.saveURLandEmail = function() {
                var emails = [];
                var emailInputFlag = true;
                var urlInputFlag = true;
                const url = document.getElementById('url').value;
                $('input[name="email[]"]').each(function() {
                    emails.push($(this).val());
                   
                });
                var isEmpty = emails.some((email)=>{
                    return email.trim() == '';
                });
                if(isEmpty && url.trim() == ''){
                    console.log('email & url empty', emails);
                }
               else if(isEmpty){
                    console.log('email is empty', emails);
                }
                else if(url.trim()== ''){
                    console.log('url is empty');
                    $('#url').css('border-color', 'red');
                    $('#res').text('Please enter a URL');
                    setTimeout(() => {
                        $('#url').css('border-color', 'red');
                        $('#res').text('Please enter a URL');
                    }, 2500);

                }
                else if(emailInputCounter == 0){
                    $("#emptyAlert").removeAttr('hidden');
                }
                else{
                    var token = $('meta[name="csrf-token"]').attr("content");
                    $.ajax({
                        url: 'store-data',
                        type: 'POST',
                        data: {
                            _token: token,
                            email: emails,
                            url: url
                        },
                        dataType: 'json/application',
                        success: function(data){
                            console.log(data.response);
                            console.log('done');
                        },
                        error: function(error){
                            console.error(error);
                        }
                    })
                }
            };
        });

        
        $("#proceedWithOutEmail").click(function(){
            console.log('proceed');
        });
        
        function saveURLandEmail() {
            var token = $('meta[name="csrf-token"]').attr("content");
            var email = $("#insertMail").val();
            var url = $("#url").val();
            var mailpatt = /([a-zA-Z0-9]+)([\_\.\-{1}]?)([a-zA-Z0-9]+)\@([a-zA-Z0-9]+)([\.])([a-zA-Z\.]+)/gi;
            var res = email.match(mailpatt);
            $.ajax({
                url: 'store-data',
                type: 'POST',
                data: {
                    url: url,
                    email: res,
                    _token: token
                },
                datatype: 'json/application',
                success: function(data) {
                    console.log(data.response);
                    console.log(data.email);
                },
                error: function(error) {
                    console.log('something went wrong');
                }

            })
            //https://www.novogene.com/us-en/
            // edrian@gmail.com ruinze@gmail.com vlagria3@gmail.com
        }


        $(document).ready(function() {
            var token = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: 'get-status',
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                contentType: 'application/json',
                success: function(response) {
                    console.log(response.asd);
                    if (response.status) {
                        console.log(response.status);
                        $.each(response.status, (index, status) => {
                            var selectEl = $("#filterStatus");
                            var appOption = `<option value="${status}">${status}</option>`;
                            selectEl.append(appOption);
                        })
                    } else {
                        console.error('Unexpected response format:', response);
                    }
                },
                error: function(error) {
                    console.error('AJAX Error:', error);
                }
            });
        });
        $("#filterStatus").on('change', function() {
            var value = $(this).val();
            filter(value);
        })
        $('#clear-filter').on('click', () => {
            $("#filterStatus").val('');
            $("#default").prop("selected", true);
            //$("#filterStatus option:not(#default)").show();
            filter('')
        });

        function filter(code) {
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: 'filter-url',
                type: 'POST',
                data: {
                    'status': code,
                    _token: csrfToken
                },
                dataType: 'json',
                success: function(response) {
                    var res = response.response;
                    var emptyRes = '<tr><td colspan="5">No matching data</td></tr>';
                    if (res.length <= 0) {
                        return $("#table-body").html(emptyRes);
                    }
                    $("#table-body").empty();
                    $.each(response.response, (index, url) => {
                        var stat = url.status;
                        var urls = url.url;
                        var toIntStat = parseInt(stat);
                        var statusInfo = statuscode[stat] || "Unknown";
                        console.log(typeof(stat));
                        console.log(stat.charAt(0));
                        switch (true) {
                            case stat.charAt(0) === '1':
                                statusInfo =
                                    `<span class="badge text-bg-secondary" style="cursor: pointer" title="${statusInfo}">${stat} ${statusInfo}</span>`;
                                break;
                            case stat.charAt(0) == '2':
                                statusInfo =
                                    `<span class="badge text-bg-success" style="cursor: pointer" title="${statusInfo}">${stat} ${statusInfo}</span>`;
                                break;
                            case stat.charAt(0) === '3':
                                statusInfo =
                                    `<span class="badge text-bg-info" style="cursor: pointer" title="${statusInfo}">${stat} ${statusInfo}</span>`;
                                break;
                            case stat.charAt(0) === '4':
                                statusInfo =
                                    `<span class="badge text-bg-warning" style="cursor: pointer" title="${statusInfo}">${stat} ${statusInfo}</span>`;
                                break;
                            case stat.charAt(0) === '5':
                                statusInfo =
                                    `<span class="badge text-bg-danger" style="cursor: pointer" title="${statusInfo}">${stat} ${statusInfo}</span>`;
                                break;
                            default:
                                statusInfo =
                                    `<span class="badge text-bg-dark" style="cursor: pointer" title="${statusInfo}">${stat} ${statusInfo}</span>`;
                                break;
                        }
                        var app = `<tr> <td>${urls}</td>
                                    <td>${statusInfo}</td> 
                                    <td><span class='badge text-bg-danger p-2' onclick="getUrlID('${url.id}','${urls}')" style="cursor: pointer" data-toggle="modal" data-target="#exampleModal">remove</span></td>
                                    <td><span class='badge text-bg-primary p-2' onclick="getEmailID('${url.id}','${urls}')" style="cursor: pointer" data-toggle="modal" data-target="#exampleModal">email</span></td>
                                    <tr>
                                    `
                        $("#table-body").append(app);
                    })
                },
                error: function(error) {
                    $('#errorAlert').removeAttr('hidden');
                },
            });
        }

        function scanURL() {
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            const url = document.getElementById('url').value;
            if (url.trim() === '') {
                $('#res').text('Please enter a URL')
                $('#res').css('color', '#F50057')
                $('#url').css('border-color', 'red')

                setTimeout(() => {
                    $('#url').css('border-color', '')
                    $('#res').css('color', '')
                    $('#res').text('Result:')
                }, 2000);
                return;
            }
            $('#loadingIndicator').show();
            $.ajax({
                url: 'scan-url',
                type: 'GET',
                data: {
                    url: url,
                    _token: csrfToken
                },
                datatype: 'json',
                success: function(data) {
                    listURL();
                    $('#loadingIndicator').hide();
                    $("#final-result").html(
                        `URL Status: <span class="badge text-bg-success">${data.status}</span>`);
                },
                error: function(xhr, status, error) {
                    console.log(error, xhr);
                    $('#errorAlert').removeAttr('hidden');
                }
            });

            function listURL() {
                $.ajax({
                    url: '/list-url',
                    type: 'GET',
                    success: function(url) {
                        var urlLists = $('#table-body');
                        urlLists.html(url);
                    },
                    error: function(error) {
                        console.log(error);
                        $('#errorAlert').removeAttr('hidden');
                    }
                });
            }
        }

        function getUrlID(id, url) {
            $("#urlRef").text(url);
            $('#removeIDRef').val(id);
        }


        function removeUrl() {
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            var remID = $('#removeIDRef').val();
            var loader = $("#loadingIndicatorModal").show();
            $.ajax({
                url: 'remove-url',
                type: 'POST',
                data: {
                    'id': remID,
                    _token: csrfToken
                },
                dataType: 'json',
                success: function(response) {
                    $("#successAlert").removeAttr('hidden');
                    $("#loadingIndicatorModal").hide();
                    $('#exampleModal button[data-dismiss="modal"]').click();
                    setTimeout(() => {
                        $("#successAlert").attr('hidden', true);
                    }, 5000);
                    listURL();
                },
                error: function(error) {
                    $("#errorAlert").removeAttr('hidden');
                }

            })

            function listURL() {
                $.ajax({
                    url: '/list-url',
                    type: 'GET',
                    success: function(url) {
                        var urlLists = $('#table-body');
                        urlLists.html(url);
                    },
                    error: function(error) {
                        console.log(error);
                        $('#errorAlert').removeAttr('hidden');
                    }
                });
            }
        }
    </script>
</body>

</html>
