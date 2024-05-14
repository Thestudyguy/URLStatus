$(document).ready(function () {
    $('#client-details').on('hidden.bs.modal', function () {
        $('.append-res').empty();
        $('.append-res button[data-card-widget="collapse"]').click();
        
    });
});


function clientDetails(id, client) {
    var client_id = id;
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var client = client;
    $("#client-details h4").html(client);
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
                let gtmCodesHtml = associatedGtmCodes.map(gtmCode => `<tr><td>${gtmCode}</td></tr>`).join('');
                let strappedUrl = url.substring(0, 31);
                let statusFirstWordOfTheStatusToDetermineTheBackgroundColorOfTheFooterToReturnComporehensiveDataReportNiggerLOL = status.substring(0, 1);
                let footerBG = '';
                let isGtmPresent;

                if (associatedGtmCodes.length > 0) {
                    isGtmPresent = associatedGtmCodes.map(gtmCode => {
                        if (gtmCode !== null) {
                            return `<tr><td>${gtmCode}</td></tr>`;
                        } else {
                            return `<tr><td>GTM Not Installed</td></tr>`;
                        }
                    }).join('');
                } else {
                    isGtmPresent = '<tr><td>GTM Not Installed</td></tr>';
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
                console.log(footerBG);
                $("#client-details div[class='append-res']").append(`
                        <div class="card direct-chat direct-chat-primary col-xl-5 col-lg-5 col-sm-12">
                        <div class="card-header" title='${url} view details'>
                        ${strappedUrl}
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                        <table class="table table-stripped" style='height: 100px'>
                            <thead>
                                <th>GTM Codes</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                    ${isGtmPresent}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        <div class="card-footer ${footerBG} m-3">
                         <div class='text-sm text-secodnary'>URL Status ${status}</div>
                        </div>
                      </div>
                `);
            });
        },
        // style='min-height: 10px; overflow: auto;'
        error: function (error, xhr, status) {
            console.log(xhr);
        }
    })
}