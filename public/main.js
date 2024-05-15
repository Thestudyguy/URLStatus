$(document).ready(function () {
    
    $('#client-details').on('hidden.bs.modal', function () {
        $('.append-res').empty();
    });
});

// $("#close-icon").on('click', function(){
    
// })

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
