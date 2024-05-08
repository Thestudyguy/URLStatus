<div class="card-container">
    @foreach($clients as $client)
        <div class="card">
            <div class="card-body">{{$client->client}}</div>
        </div>
    @endforeach
</div>
