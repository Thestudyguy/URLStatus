<div id="accordion">
    @foreach($clients as $client)
    <div class="card">
        <div class="card-header" id="heading{{$client->id}}">

            <h5 class="mb-0 d-flex justify-content-between align-items-center">
                <button id="clientDetails-link-{{$client->id}}" onclick="clientDetails('{{$client->id}}','{{$client->client}}')" class="client-details-link btn btn-link" data-toggle="collapse" data-target="#collapse{{$client->id}}" aria-expanded="true" aria-controls="collapse{{$client->id}}">
                    {{$client->client}}
                </button>
                <button hidden class="close-icon btn btn-transparent btn-sm" id="close-icon-{{$client->id}}" onclick="toggleAccordion('#collapse{{$client->id}}')">
                    <i class="fas fa-minus"></i>
                </button>
            </h5>
        </div>

        <div id="collapse{{$client->id}}" class="collapse" aria-labelledby="heading{{$client->id}}" data-parent="#accordion">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>URL</th>
                            <th>Status</th>
                            <th>GTM Codes</th>
                        </tr>
                    </thead>
                    <tbody id="urls_{{$client->id}}">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script>
var clientDetailsLinks = document.querySelectorAll('.client-details-link');
clientDetailsLinks.forEach(function(clientDetailsLink) {
    var closeIcon = clientDetailsLink.nextElementSibling;
    clientDetailsLink.addEventListener('click', function() {
        closeIcon.hidden = !closeIcon.hidden;
    });
    closeIcon.addEventListener('click', function() {
        closeIcon.hidden = !closeIcon.hidden;
    });
});

</script>