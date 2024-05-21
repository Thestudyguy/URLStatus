$(document).ready(function () {
    
    $('#client-details').on('hidden.bs.modal', function () {
        $('.append-res').empty();
    });
});
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
});


function toggleAccordion(collapseId) {
    console.log('opened');
    var collapse = $(collapseId);
    collapse.collapse('toggle');
}
function clientDetails(id, client) {
    var client_id = id;
    console.log(id, client);
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var client = client;
    $("#client-details h4").html(client);
    $("#urls_" + id).empty();
    $.ajax({
        url: 'client-details/' + id,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        method: 'POST',
        success: function (response) {
            let uniqueUrls = [...new Set(response.data.map(entry => entry.url))];
            let uniqueDataMap = new Map();
            response.data.forEach(entry => {
                if (!uniqueDataMap.has(entry.url)) {
                    uniqueDataMap.set(entry.url, { gtmCodes: new Set(), status: entry.status });
                }
                uniqueDataMap.get(entry.url).gtmCodes.add(entry.gtm_codes);
            });
            let uniqueData = Array.from(uniqueDataMap, ([url, data]) => ({ url, gtmCodes: [...data.gtmCodes], status: data.status }));
            uniqueUrls.forEach(url => {
                let dataForUrl = uniqueData.find(entry => entry.url === url);
                let associatedGtmCodes = dataForUrl.gtmCodes;
                let status = dataForUrl.status;
                let gtmCodesHtml = associatedGtmCodes.map(gtmCode => `${gtmCode}`).join('');
                let strappedUrl = url.substring(0, 31);
                let statusFirstWordOfTheStatusToDetermineTheBackgroundColorOfTheFooterToReturnComporehensiveDataReportNiggerLOL = status.substring(0, 1);
                let footerBG = '';
                let isGtmPresent;

                if (associatedGtmCodes.length > 0) {
                    isGtmPresent = associatedGtmCodes.map(gtmCode => {
                        if (gtmCode !== null) {
                            return `${gtmCode}`;
                        } else {
                            return `GTM Not Installed`;
                        }
                    }).join('');
                } else {
                    isGtmPresent = '<tr><td>GTM Not Installed';
                }
                console.log(statusFirstWordOfTheStatusToDetermineTheBackgroundColorOfTheFooterToReturnComporehensiveDataReportNiggerLOL);
                if (statusFirstWordOfTheStatusToDetermineTheBackgroundColorOfTheFooterToReturnComporehensiveDataReportNiggerLOL == 1) {
                    footerBG = 'bg-info';
                }
                if (statusFirstWordOfTheStatusToDetermineTheBackgroundColorOfTheFooterToReturnComporehensiveDataReportNiggerLOL == 2) {
                    footerBG = 'bg-success';
                }
                if (statusFirstWordOfTheStatusToDetermineTheBackgroundColorOfTheFooterToReturnComporehensiveDataReportNiggerLOL == 3) {
                    footerBG = 'bg-secondary';
                }
                if (statusFirstWordOfTheStatusToDetermineTheBackgroundColorOfTheFooterToReturnComporehensiveDataReportNiggerLOL == 4) {
                    footerBG = 'bg-warning';
                }
                if (statusFirstWordOfTheStatusToDetermineTheBackgroundColorOfTheFooterToReturnComporehensiveDataReportNiggerLOL == 5) {
                    footerBG = 'bg-danger';
                }
                console.log(strappedUrl, status);
                console.log(gtmCodesHtml);
                $("#urls_" + id).append(`
                    <tr>
                        <td>${url}</td>
                        <td><span class='badge ${footerBG}'>${status}</span></td>
                        <td class='text-sm'>${isGtmPresent}</td>
                    </tr>
        `);
            });
        },
        error: function (error, xhr, status) {
            console.log(xhr);
        }
    })
}

function removeClient(id, client) {
    var deleteAlert = $(`#delete-alert-${id}`);
    deleteAlert.fadeIn();
    deleteAlert.removeAttr('hidden');
    deleteAlert.html(`Are you sure you want to remove ${client} ? 
    <span style='cursor: pointer; font-size: .8rem;' class="badge p-2 text-bg-danger" onclick="confirmDelete(${id}, true)">Yes</span>
    <span style='cursor: pointer; font-size: .8rem;' class="badge p-2 text-bg-success" onclick="confirmDelete(${id}, false)">No</span>
    `);
}

function confirmDelete(id, confirm) {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var deleteAlert = $(`#delete-alert-${id}`);
    if (confirm) {
        deleteAlert.attr('hidden', 'hidden');
        $.ajax({
            url: 'remove-client',
            method: 'POST',
            data: {'id' : id, '_token' : csrfToken},
            success: function(response){
                getClients();
                console.log(response);
                Toast.fire({
                    icon: 'success',
                    title: 'Removed',
                    text: 'Client removed successfully!'
                });
            },
            error: function(xhr, status, error){
                console.log(xhr);
                Toast.fire({
                    icon: 'error',
                    title: 'Error',
                    title: 'Something went horribly wrong'
                });
            }
        });
    } else {
        deleteAlert.attr('hidden', 'hidden');
    }
}
    function resClients() {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        url: "get-url",
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        success: function (client) {
                var htmlContent = '';
                htmlContent += `<div class="card">
                    <div class="card-header" id="heading${client.id}">
                        <h5 class="mb-0 d-flex justify-content-between align-items-center">
                            <button id="clientDetails-link-${client.id}" onclick="clientDetails('${client.id}','${client.client}')" class="client-details-link btn btn-link" data-toggle="collapse" data-target="#collapse${client.id}" aria-expanded="true" aria-controls="collapse${client.id}">
                            ${client.client}
                            </button>
                            <button hidden class="close-icon btn btn-transparent btn-sm" id="close-icon-${client.id}" onclick="toggleAccordion('#collapse${client.id}')">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button class="remove-icon btn btn-danger btn-sm" id="${client.id}" onclick="removeClient('${client.id}','${client.client}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </h5>
                    </div>
                    <div id="collapse${client.id}" class="collapse" aria-labelledby="heading${client.id}" data-parent="#accordion">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>URL</th>
                                        <th>Status</th>
                                        <th>GTM Codes</th>
                                    </tr>
                                </thead>
                                <tbody id="urls_${client.id}">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer" id="delete-alert-${client.id}" hidden>
                    </div>
                </div>`;
            $('#accordion').html(htmlContent);
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load clients. Please try again.'
                });
            }
        });
    }
    