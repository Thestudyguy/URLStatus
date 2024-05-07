<div class="card-container">
    @foreach($lists as $urls)
    @php
    $status = $urls->status;
    $statusStand ='';
    $statusChar = substr($status,0,1);
    @endphp
    @if($urls->IsVisible)
    <div class="card">
    <div class="card-header">{{$urls->url}}</div>
    <div class="card-body">GTMCodes</div>
    @switch($statusChar)
        @case($statusChar == 1)
        <div class="card-footer bg-secondary"><b>Status: </b>{{ $urls->status }} </div>
        @break
        @case($statusChar == 2)
        <div class="card-footer bg-success"><b>Status: </b>{{ $urls->status }} </div>
        @break
        @case($statusChar == 3)
        <div class="card-footer bg-warning"><b>Status: </b>{{ $urls->status }}</div>
        @break
        @case($statusChar == 4)
        <div class="card-footer bg-warning"><b>Status: </b>{{ $urls->status }}</div>
        @break
        @case($statusChar == 5)
        <div class="card-footer bg-danger"><b>Status: </b>{{ $urls->status }}</div>
        @break
        @default
        <div class="card-footer bg-dark"><b>Status: </b>{{ $urls->status }} Unknown</div>
        @endswitch
    </div>
    @endif
    @endforeach
</div>