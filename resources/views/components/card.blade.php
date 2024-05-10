<div class="card-container " id="client-card">
    @foreach($clients as $client)
        <div class="card" style="cursor: pointer;" id="{{$client->id}}" onclick="clientDetails('{{$client->id}}','{{$client->client}}')" data-target="#client-details" data-toggle="modal"> 
            <div class="card-body">{{$client->client}}</div>
            <div class="card-footer">
                {{-- <button class="btn btn-danger btn-sm">Remove Client</button> --}}
                {{-- <button class="btn btn-primary btn-sm" data-target="#client-details" data-toggle="modal" id="{{$client->id}}">View Details</button> --}}
            </div>
        </div>
        @include('components.client-details')
    @endforeach
</div>
