@section('card')
<div class="card-container">
    @foreach($clients as $client)
        <div class="card">
            <div class="card-header">{{$client->client}}</div>
            <div class="card-body">{{$client->email}}</div>
            asd
        </div>
    @endforeach
</div>
@endsection
