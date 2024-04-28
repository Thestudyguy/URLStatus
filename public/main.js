let emailInputCounter = 1;
$(document).ready(function () {
    $('#urlemailModal').on('hidden.bs.modal', function () {
        $('#url').val('');
        $("#url").css("border-color", "");
        $('#emailInputs').html(`
    <div class="input-group mt emailInput" id="emailInputGroup_1">
        <input type="email" class="form-control emailInput" placeholder="Enter Email" name="email[]" required>
        <button class="btn btn-outline-danger px-3" id="testID" type="button" onclick="removeEmailInput(1)">Remove</button>
    </div>
`);
        $('#mdlAlrt').addClass('visually-hidden');
        //very
        emailInputCounter = 1;
        if(emailInputCounter == 1){
            return $("#addEmailInput").removeAttr("disabled");
        }
        //ezzzzzzz
    });
});
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

function getEmail(id, url) {
    var token = $('meta[name="csrf-token"]').attr("content");
    $("#title").text(url);
    $.ajax({
        url: 'get-email/' + id,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        datatype: 'json/application',
        success: function (data) {
            var email = data.res;
            email.forEach(emails => { });
        },
        error: function (error) { }
    })
}

function getUrlID(id, url) {
    $("#urlRef").text(url);
    $('#removeIDRef').val(id);
}

$(document).ready(function () {
    $("#addEmailInput").click(function () {
        emailInputCounter++;
        var emailInputHtml =
            '<div class="input-group mt-2 emailInputWrapper" id="emailInputGroup_' +
            emailInputCounter + '">' +
            '<input type="email" class="form-control emailInput" placeholder="Enter Email" name="email[]" required>' +
            '<button class="btn btn-outline-danger px-3" type="button" onclick="removeEmailInput(' +
            emailInputCounter + ')">Remove</button>' +
            '</div>';
        $("#emailInputs").append(emailInputHtml);
        $("#emailInputGroup_" + emailInputCounter).hide().slideDown();
        if (emailInputCounter >= 5) {
            alert(
                "You reached the maximum limit for email(5 email)."
            );
            return $("#addEmailInput").attr("disabled", "true");
        }
    });

    window.removeEmailInput = function (inputId) {
        $("#emailInputGroup_" + inputId).fadeOut(function () {
            $(this).remove();
        });
        emailInputCounter--;
    };

});


function saveURLandEmail() {
    const url = $('#url').val().trim();
    const emails = $('input[name="email[]"]').map(function () {
        return $(this).val().trim();
    }).get();

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const urlPattern = /\b(?:https?:\/\/|ftp:\/\/|www\.)[-A-Za-z0-9+&@#\/%?=~_|!:,.;]*[-A-Za-z0-9+&@#\/%=~_|]/;


    if (!urlPattern.test(url)) {
        $('#url').css('border-color', 'red');
        $('#res').text('Please enter a valid URL');
        return;
    }

    if (emails.length === 0 || emails.some(email => !emailPattern.test(email))) {
        $('input[name="email[]"]').css('border-color', 'red');
        return;
    }

    $('input[name="email[]"]').css('border-color', '');

    const token = $('meta[name="csrf-token"]').attr("content");
    const requestData = {
        _token: token,
        email: emails,
        url: url
    };

    $("#saveBtn").addClass("disabled");
    $("#samText").text("processing");
    $("#loadingIndicatorSave").show();

    $.ajax({
        url: 'store-data',
        type: 'POST',
        data: requestData,
        dataType: 'json',
        success: function (data) {
            $("#saveBtn").removeClass("disabled");
            $("#samText").text("Scan & save");
            $("#loadingIndicatorSave").hide();
            $("#mdlAlrt").removeClass('visually-hidden').addClass('alert-success');
            $("#alertTitle").text("URL Added");
            $('#pasText').text('New URL Added');

            setTimeout(() => {
                $("#urlemailModal button#closeSaveModal").click();
                $("#infoModal").modal('show');
                const statusInfo = statuscode[data.status] || 'Unknown';
                const statusBadge =
                    `<span class="badge ${getStatusBadgeClass(data.character)}" style="cursor: pointer" title="${statusInfo}">${data.status} ${statusInfo}</span>`;
                $("#url_status").html(`URL: <a href='${data.url}'>${data.url}</a>`);
                $("#url_text").html(`Status: ${statusBadge}`);
            }, 2000);

            listURL();
        },
        error: function (xhr, status, error) {
            const errorMessage = xhr.responseJSON ? xhr.responseJSON.error : 'Unknown error';
            $("#saveBtn").removeClass("disabled");
            $("#samText").text("Scan & save");
            $("#loadingIndicatorSave").hide();
            $("#mdlAlrt").removeClass('visually-hidden').addClass('alert-danger');
            $("#alertTitle").text("Error");
            $('#pasText').text(errorMessage);
        }
    });
}


function listURL() {
    $.ajax({
        url: '/list-url',
        type: 'GET',
        success: function (url) {
            var urlLists = $('#table-body');
            urlLists.html(url);
        },
        error: function (error) {
            $('#errorAlert').removeAttr('hidden');
        }
    });
}



$(document).ready(function () {
    var token = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        url: 'get-status',
        type: 'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': token
        },
        contentType: 'application/json',
        success: function (response) {
            if (response.status) {
                $.each(response.status, (index, status) => {
                    var selectEl = $("#filterStatus");
                    var appOption = `<option value="${status}">${status}</option>`;
                    selectEl.append(appOption);
                })
            } else {
                console.error('Unexpected response format:', response);
            }
        },
        error: function (error) {
            console.error('AJAX Error:', error);
        }
    });
});
$("#filterStatus").on('change', function () {
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
    $("#loadingIndicatorTable").show();
    $.ajax({
        url: 'filter-url',
        type: 'POST',
        data: {
            'status': code,
            _token: csrfToken
        },
        dataType: 'json',
        success: function (response) {
            $("#loadingIndicatorTable").hide();
            var res = response.response;
            var emptyRes = '<tr><td colspan="5">No matching data</td></tr>';
            if (res.length <= 0) {
                return $("#table-body").html(emptyRes);
            }
            $("#table-body").empty();
            $.each(response.response, (index, url) => {
                const statusBadge = getStatusBadge(url.status);
                const row = `<tr>
                <td>${url.url}</td>
                <td>${statusBadge}</td> 
                <td><span class='badge text-bg-danger p-2' onclick="getUrlID('${url.id}','${url.url}')" style="cursor: pointer" data-toggle="modal" data-target="#exampleModal">remove</span></td>
            </tr>`;
                $("#table-body").append(row);
            });
        },
        error: function (error) {
            $("#exampleModalLabel").text(error.errors);
        },
    });
}



$(document).ready(function () {
    $("#loadingIndicatorModal").hide();
});

function removeUrl() {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var remID = $('#removeIDRef').val();
    $("#loadingIndicatorModal").show();
    $("#removeBtn").addClass('disabled');
    $.ajax({
        url: 'remove-url',
        type: 'POST',
        data: {
            'id': remID,
            _token: csrfToken
        },
        dataType: 'json',
        success: function (response) {
            $("#successAlert").removeAttr('hidden');
            $("#loadingIndicatorModal").hide();
            $('#exampleModal button[data-dismiss="modal"]').click();
            $("#loadingIndicatorModal").hide();
            $("#removeBtn").removeClass('disabled');
            setTimeout(() => {
                $("#successAlert").attr('hidden', true);
            }, 5000);
            listURL();
        },
        error: function (error) {
            $("#errorAlert").removeAttr('hidden');
        }

    })

    function listURL() {
        $.ajax({
            url: '/list-url',
            type: 'GET',
            success: function (url) {
                var urlLists = $('#table-body');
                urlLists.html(url);
            },
            error: function (error) {
                $('#errorAlert').removeAttr('hidden');
            }
        });
    }
}

function getStatusBadgeClass(status) {
    switch (status.charAt(0)) {
        case '1':
            return 'text-bg-secondary';
        case '2':
            return 'text-bg-success';
        case '3':
            return 'text-bg-info';
        case '4':
            return 'text-bg-warning';
        case '5':
            return 'text-bg-danger';
        default:
            return 'text-bg-dark';
    }
}

function getStatusBadge(status) {
    const statusInfo = statuscode[status] || 'Unknown';
    const badgeClass = getStatusBadgeClass(status);
    return `<span class="badge ${badgeClass}" style="cursor: pointer" title="${statusInfo}">${status} ${statusInfo}</span>`;
}