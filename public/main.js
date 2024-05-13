$(document).ready(function () {
    $('#client-details').on('hidden.bs.modal', function () {
        $('.append-res').empty();
    });
});


function clientDetails(id, client) {
    var client_id = id;
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var client = client;
    //console.log(`client ${client} \n client id ${client_id}`);
    $("#client-details h4").html(client);
    $.ajax({
        url: 'client-details/' + id,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        method: 'POST',
        success: function (response) {
            console.log(response);
            console.log(response.client);
            console.log(response.url);
            console.log(response.gtm_codes);
            //url.forEach(urls => {
            //    $("#client-details div[class='append-res']").append(`
            //        <div class="card direct-chat direct-chat-primary col-5" id="client">
            //            <div class="card-header">
            //                <h3 class="card-title" style='cursor: pointer;' title='${urls.url}'>${urls.url.substring(0, 31)}</h3>
            //                <div class="card-tools">
            //                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
            //                        <i class="fas fa-minus"></i>
            //                    </button>
            //                </div>
            //            </div>
            //            <div class="card-body p-2" id="card-body-flex">
            //                    <p>Status ${urls.status}</p>
            //            </div>
            //        </div>
            //    `);
            //});
        },
        error: function (error, xhr, status) {
            console.log(xhr);
        }
    })
}
