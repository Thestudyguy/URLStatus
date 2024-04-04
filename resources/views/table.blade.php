
                @foreach ($lists as $list)
                @if ($list->IsVisible)
                <tr>
                    <td>{{$list->url}}</td>
                    @switch($list->status)
                        @case('200')
                            <td><span class="badge text-bg-success">{{$list->status}}</span></td>
                            @break
                        @case($list->status >= 400 && $list->status < 500)
                            <td><span class="badge text-bg-warning">{{$list->status}}</span></td>
                            @break
                        @case($list->status >= 500 && $list->status < 600)
                            <td><span class="badge text-bg-danger">{{$list->status}}</span></td>
                            @break
                        @default
                            <td><span class="badge text-bg-secondary">{{$list->status}}</span></td>
                    @endswitch
                    <td><span class="badge text-bg-danger p-2" onclick="getUrlID('{{ $list->id }}', '{{ $list->url }}')" style="cursor: pointer" data-toggle="modal" data-target="#exampleModal">remove</span></td>
                </tr>
                @endif
            @endforeach
            