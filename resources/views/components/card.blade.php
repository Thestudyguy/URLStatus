<div class="card-container" id="client-card" style='max-height: 350px; overflow:auto;' disabled>
    <table class="table table-stripped">
        <thead>
            <th>Client</th>
            <th>Details</th>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
                <td>{{$client->client}} 
                    @include('components.client-details')
                   <div class="asd" id="visually-hidden-client-details">
                    here
                   </div>
                </td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="clientDetails('{{$client->id}}','{{$client->client}}')" id="{{$client->id}}">View</button>
                    <button class="btn btn-primary btn-sm" onclick="test()">View</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
