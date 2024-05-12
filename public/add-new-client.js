let emailInputCounter = 1;
let UrlInputCounter = 1;
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
});

$(document).ready(function () {
    $("#overlay").hide();
    $('#new-client').on('hidden.bs.modal', function () {
        console.log('oten bisong hahaha');
    });
});
//email
$("#add-email-button").click(
    function () {
        emailInputCounter++;
        var emailInputHtml =
            '<div class="input-group mt-2 emailInputWrapper" id="emailInputGroup_' +
            emailInputCounter + '">' +
            '<input type="email" class="form-control emailInput" placeholder="Enter Email" name="email[]" required>' +
            '<button class="btn btn-outline-danger px-3" type="button" onclick="removeEmailInput(' +
            emailInputCounter + ')">Remove</button>' +
            '</div>';
        $(".input-group-email").append(emailInputHtml);
    }
);
window.removeEmailInput = function (inputId) {
    $("#emailInputGroup_" + inputId).fadeOut(function () {
        $(this).remove();
        emailInputCounter--;
    });
}

//url
$("#add-url-button").click(
    function () {
        UrlInputCounter++;
        var UrlInputHtml = '<div class="input-group mt-2 urlInputWrapper" id="urlInputGroup_' +
            UrlInputCounter + '">' +
            '<input type="text" class="form-control urlInput" placeholder="Enter Url" name="url[]" required>' +
            '<button class="btn btn-outline-danger px-3" type="button" onclick="removeUrlInput(' +
            UrlInputCounter + ')">Remove</button>' +
            '</div>';
        $(".input-group-url").append(UrlInputHtml);
    }
)
window.removeUrlInput = function (inputId) {
    $("#urlInputGroup_" + inputId).fadeOut(function () {
        $(this).remove();
        emailInputCounter--;
    });
}

$("#saveBtn").click(
    function () {
        $("#overlay").show();
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var client = $("#client").val();
        var client_email = $("#email").val();
        var client_contact = $("#contact").val();
        var email = [];
        var url = [];
        //var gtm_codes_regex = /GTM-([^"\'>]+)(?!\\)[^'"\/>]/gi;
        $("input[name='email[]'], input[name='url[]']").each(function () {
            var value = $(this).val().trim();
            if (value !== '') {
                if ($(this).attr('name') === 'email[]') {
                    email.push(value);
                } else if ($(this).attr('name') === 'url[]') {
                    url.push(value);
                }
            }
        });
        console.log(email);
        console.log(url);
        $.ajax({
            type: 'POST',
            url: "save-new",
            data: {
                client: client,
                client_email: client_email,
                client_contact: client_contact,
                url: url,
                email: email,
                url: url,
                _token: csrfToken,
            },
            success: function (response) {
                console.log(response);
                $("#overlay").hide();
                $("#new-client button[data-dismiss='modal']").click();
                //swalAlert('success');
                $(".swalDefaultSuccess").click();
                console.log('success');
                console.log(response.id);
                getClients();
            },
            error: function (xhr, status, error) {
                $("#overlay").hide();
                console.log(xhr);
                console.log('error');
                $("#alert-error-container").html(`
                <div class='p-3'>
                <div class="alert alert-danger">
                <strong class="text-light">Oops!</strong>
                <p class="text-sm" id="error-container">Something went wrong!</p>
                </div>
                </div>
                `);
                setTimeout(() => {
                    $("#alert-error-container").empty()
                }, 3500);
            }

        })
    }
);
function getClients() {
    $.ajax({
        url: "/clients",
        method: 'GET',
        success: function (response) {
            console.log(response);
            $("#client-card").append(`
            <div class="card" style="cursor: pointer;" id="${response.id}" onclick="clientDetails('{{$client->id}}','{{$client->client}}')" data-target="#client-details" data-toggle="modal"> 
            <div class="card-body">${response.client}</div>
            <div class="card-footer">
            
            </div>
        </div>
            `);
            console.log(response);
        },
        error: function (xhr, status, error) {
        },
    });
}
$('.swalDefaultSuccess').click(function () {
    Toast.fire({
        icon: 'success',
        title: 'New Client Added'
    })
});
