$(document).ready(function () {
    $('#client-details').on('hidden.bs.modal', function () {
        $('.append-res').empty();
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
            console.log(response);
            uniqueUrls.forEach(url => {
                console.log(url);
                let dataForUrl = uniqueData.find(entry => entry.url === url);
                let associatedGtmCodes = dataForUrl.gtmCodes;
                let status = dataForUrl.status;
                let gtmCodesHtml = associatedGtmCodes.length >= 0 ? associatedGtmCodes.map(gtmCode => `<tr><td>${gtmCode}</td></tr>`).join('') : '<tr><td>GTM Not Installed</td></tr>';
                let isGtmEmpty = '';
                console.log(gtmCodesHtml);
                let strappedUrl = url.substring(0, 31);
                let statusFirstWordOfTheStatusToDetermineTheBackgroundColorOfTheFooterToReturnComporehensiveDataReportNiggerLOL = status.substring(0, 1);
                let footerBG = '';
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
                        <div class="card direct-chat direct-chat-primary col-5">
                        <div class="card-header" title='${url}'>
                        ${strappedUrl}
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                        <table class="table table-stripped">
                            <thead>
                                <th>GTM Codes</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                    ${gtmCodesHtml ? gtmCodesHtml : 'Oten haha'}
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
        
        error: function (error, xhr, status) {
            console.log(xhr);
        }
    })
}