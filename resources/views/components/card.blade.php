<div class="card-container" id="client-card">
    @foreach($clients as $client)
        <div class="card">
            <div class="card-body">{{$client->client}}</div>
        </div>
    @endforeach
</div>
