let emailInputCounter = 1;
let UrlInputCounter = 1;
$(document).ready(function(){
    $("#overlay").hide();
});

$(document).ready(function () {
    $('#new-client').on('hidden.bs.modal', function () {
        console.log('oten bisong hahaha');
        //clear form if modal is not visible
    });
});
//email
$("#add-email-button").click(
    function() {
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
    function(){
        UrlInputCounter++;
        var UrlInputHtml =  '<div class="input-group mt-2 urlInputWrapper" id="urlInputGroup_' +
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
    function() {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var client = $("#client").val();
        var client_email = $("#email").val();
        var client_contact = $("#contact").val();
        var email = [];
        var url = [];
        var gtm_codes_regex = /GTM-([^"\'>]+)(?!\\)[^'"\/>]/gi;
        $("input[name='email[]'], input[name='url[]']").each(function() {
            var value = $(this).val().trim();
            if (value !== '') {
                if ($(this).attr('name') === 'email[]') {
                    email.push(value);
                } else if ($(this).attr('name') === 'url[]') {
                    url.push(value);
                }
            }
        });
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
            success: function(response){
                console.log(response);
            },
            error: function(xhr, status, error){
                console.log(xhr);
            }

        })
        }
);
