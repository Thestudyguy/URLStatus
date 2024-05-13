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
            
            // Create a map to store unique GTM codes and status for each URL
            let uniqueDataMap = new Map();
            response.data.forEach(entry => {
                if (!uniqueDataMap.has(entry.url)) {
                    uniqueDataMap.set(entry.url, { gtmCodes: new Set(), status: entry.status });
                }
                uniqueDataMap.get(entry.url).gtmCodes.add(entry.gtm_codes);
            });
            
            // Convert the map to an array of objects containing URL, GTM codes, and status
            let uniqueData = Array.from(uniqueDataMap, ([url, data]) => ({ url, gtmCodes: [...data.gtmCodes], status: data.status }));
        
            uniqueUrls.forEach(url => {
                console.log(url);
                let dataForUrl = uniqueData.find(entry => entry.url === url);
                let associatedGtmCodes = dataForUrl.gtmCodes;
                let status = dataForUrl.status;
        
                let gtmCodesHtml = associatedGtmCodes.map(gtmCode => `<tr><td>${gtmCode}</td></tr>`).join('');
                
                $("#client-details div[class='append-res']").append(`
                    <div class="card col-5">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>${url}</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${gtmCodesHtml}
                                <tr><td>Status: ${status}</td></tr>
                            </tbody>
                        </table>
                    </div>
                `);
            });
        },
        
        
        
        error: function (error, xhr, status) {
            console.log(xhr);
        }
    })
}