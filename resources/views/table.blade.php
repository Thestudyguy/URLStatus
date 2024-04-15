@foreach ($lists as $list)
    @if ($list->IsVisible)
        <tr>
            <td>{{ $list->url }}</td>
            @php
                $status = $list->status;
                $statusChar = substr($status,0,1);
                $statuscode = [
                    100 => 'Continue',
                    101 => 'Switching Protocols',
                    200 => 'OK',
                    201 => 'Created',
                    202 => 'Accepted',
                    203 => 'Non-Authoritative Information',
                    204 => 'No Content',
                    205 => 'Reset Content',
                    206 => 'Partial Content',
                    300 => 'Multiple Choices',
                    301 => 'Moved Permanently',
                    302 => 'Found',
                    303 => 'See Other',
                    304 => 'Not Modified',
                    305 => 'Use Proxy',
                    306 => 'Switch Proxy',
                    307 => 'Temporary Redirect',
                    400 => 'Bad Request',
                    401 => 'Unauthorized',
                    402 => 'Payment Required',
                    403 => 'Forbidden',
                    404 => 'Not Found',
                    405 => 'Method Not Allowed',
                    406 => 'Not Acceptable',
                    407 => 'Proxy Authentication Required',
                    408 => 'Request Timeout',
                    409 => 'Conflict',
                    410 => 'Gone',
                    411 => 'Length Required',
                    412 => 'Precondition Failed',
                    413 => 'Request Entity Too Large',
                    414 => 'Request-URI Too Long',
                    415 => 'Unsupported Media Type',
                    416 => 'Requested Range Not Satisfiable',
                    417 => 'Expectation Failed',
                    418 => "I'm a teapot", // April Fools joke
                    500 => 'Internal Server Error',
                    501 => 'Not Implemented',
                    502 => 'Bad Gateway',
                    503 => 'Service Unavailable',
                    504 => 'Gateway Timeout',
                    505 => 'HTTP Version Not Supported',
                    525 => 'SSL Handshake Failed'
                ];

                $statusInfo = $statuscode[$list->status] ?? 'Unknown';
            @endphp
            @switch($statusChar)
            @case($statusChar == 1)
                    <td><span class="badge text-bg-secondary" style="cursor: pointer"
                            title="{{ $statusInfo }}">{{ $list->status }} {{ $statusInfo }}</span></td>
                @break
                @case($statusChar == 2)
                    <td><span class="badge text-bg-success" style="cursor: pointer"
                            title="{{ $statusInfo }}">{{ $list->status }} {{ $statusInfo }}</span></td>
                @break

                @case($statusChar == 3)
                    <td><span class="badge text-bg-info" style="cursor: pointer"
                            title="{{ $statusInfo }}">{{ $list->status }} {{ $statusInfo }}</span></td>
                @break

                @case($statusChar == 4)
                    <td><span class="badge text-bg-warning" style="cursor: pointer"
                            title="{{ $statusInfo }}">{{ $list->status }} {{ $statusInfo }}</span></td>
                @break
                @case($statusChar == 5)
                    <td><span class="badge text-bg-danger" style="cursor: pointer"
                            title="{{ $statusInfo }}">{{ $list->status }} {{ $statusInfo }}</span></td>
                @break

                @default
                    <td><span class="badge text-bg-secondary" style="cursor: pointer">{{ $list->status }}</span></td>
            @endswitch
            <td><span class="badge text-bg-danger p-2" onclick="getUrlID('{{ $list->id }}', '{{ $list->url }}')"
                    style="cursor: pointer" data-toggle="modal" data-target="#exampleModal">remove</span></td>
        </tr>
    @endif
@endforeach