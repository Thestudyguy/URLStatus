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

$("#add-email-button").click(function () {
    emailInputCounter++;
    var emailInputHtml =
        '<div class="input-group mt-2 emailInputWrapper" id="emailInputGroup_' + emailInputCounter + '">' +
        '<input type="email" class="form-control emailInput" placeholder="Enter Email" name="email[]" required>' +
        '<button class="btn btn-outline-danger px-3" type="button" onclick="removeEmailInput(' + emailInputCounter + ')">Remove</button>' +
        '</div>';
    $(".input-group-email").append(emailInputHtml);
});

window.removeEmailInput = function (inputId) {
    $("#emailInputGroup_" + inputId).fadeOut(function () {
        $(this).remove();
        emailInputCounter--;
    });
};

$("#add-url-button").click(function () {
    UrlInputCounter++;
    var UrlInputHtml = '<div class="input-group mt-2 urlInputWrapper" id="urlInputGroup_' + UrlInputCounter + '">' +
        '<input type="text" class="form-control urlInput" placeholder="Enter Url" name="url[]" required>' +
        '<button class="btn btn-outline-danger px-3" type="button" onclick="removeUrlInput(' + UrlInputCounter + ')">Remove</button>' +
        '</div>';
    $(".input-group-url").append(UrlInputHtml);
});

window.removeUrlInput = function (inputId) {
    $("#urlInputGroup_" + inputId).fadeOut(function () {
        $(this).remove();
        UrlInputCounter--;
    });
};

$("#saveBtn").click(function () {
    $("#overlay").show();
    clearAlert();

    var urlRegex = /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var client = $("#client").val().trim();
    var client_email = $("#email").val().trim();
    var client_contact = $("#contact").val().trim();
    var emails = [];
    var urls = [];
    var hasErrors = false;

    $("input[name='email[]']").each(function () {
        var value = $(this).val().trim();
        if (value !== '') {
            if (!emailRegex.test(value)) {
                displayAlert('Invalid email format: ' + value);
                hasErrors = true;
            } else {
                emails.push(value);
            }
        }
    });

    $("input[name='url[]']").each(function () {
        var value = $(this).val().trim();
        if (value !== '') {
            if (!urlRegex.test(value)) {
                displayAlert('Invalid URL format: ' + value);
                hasErrors = true;
            } else {
                urls.push(value);
            }
        }
    });

    if (client === '' || client_email === '' || client_contact === '') {
        displayAlert('Please fill in all required fields.');
        hasErrors = true;
    }
    if (emails.length === 0) {
        displayAlert('Please add at least one email.');
        hasErrors = true;
    }
    if (urls.length === 0) {
        displayAlert('Please add at least one URL.');
        hasErrors = true;
    }

    if (hasErrors) {
        $("#overlay").hide();
        return;
    }

    $.ajax({
        type: 'POST',
        url: "save-new",
        data: {
            client: client,
            client_email: client_email,
            client_contact: client_contact,
            url: urls,
            email: emails,
            _token: csrfToken,
        },
        success: function (response) {
            $("#overlay").hide();
            $("#new-client button[data-dismiss='modal']").click();
            $(".swalDefaultSuccess").click();
            getClients();
        },
        error: function (xhr, status, error) {
            $("#overlay").hide();
            displayAlert('Something went wrong. Please try again.');
        }
    });
});

function displayAlert(message) {
    $("#alert-error-container").html(`
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `);
}

function clearAlert() {
    $("#alert-error-container").empty();
}

function getClients() {
    $.ajax({
        url: "/clients",
        method: 'GET',
        success: function (response) {
            //response.forEach(element => {
            //    console.log(element);
            //});
            console.log(response.id);
            console.log(response.client);
            console.log(response);
            $("#accordion").append(`
                        <div class="card">
                            <div class="card-header" id="heading${response.id}">
                                <h5 class="mb-0 d-flex justify-content-between align-items-center">
                                    <button id="clientDetails-link-${response.id}" onclick="clientDetails('${response.id}','${response.client}')" class="client-details-link btn btn-link" data-toggle="collapse" data-target="#collapse${response.id}" aria-expanded="true" aria-controls="collapse${response.id}">
                                        ${response.client}
                                    </button>
                                    <button hidden class="close-icon btn btn-transparent btn-sm" id="close-icon-${response.id}" onclick="toggleAccordion('#collapse${response.id}')">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse${response.id}" class="collapse" aria-labelledby="heading${response.id}" data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>URL</th>
                                                <th>Status</th>
                                                <th>GTM Codes</th>
                                            </tr>
                                        </thead>
                                        <tbody id="urls_${response.id}">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    `);
            attachClientDetailsLinksListeners();
        },
        error: function (xhr, status, error) {
            displayAlert('Failed to load clients. Please try again.');
        }
    });
}

function attachClientDetailsLinksListeners() {
    var clientDetailsLinks = document.querySelectorAll('.client-details-link');
    clientDetailsLinks.forEach(function (clientDetailsLink) {
        var closeIcon = clientDetailsLink.nextElementSibling;
        clientDetailsLink.addEventListener('click', function () {
            closeIcon.hidden = !closeIcon.hidden;
        });
        closeIcon.addEventListener('click', function () {
            closeIcon.hidden = !closeIcon.hidden;
        });
    });
}

$(document).ready(function () {
    attachClientDetailsLinksListeners();
});

$('.swalDefaultSuccess').click(function () {
    Toast.fire({
        icon: 'success',
        title: 'New Client Added'
    });
});
