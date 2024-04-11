<html>

<head>
</head>

<body style="display: flex; flex-direction: column;">
        <div class="card-body" style="display: flex; justify-content: start; align-items: start; flex-direction: column; border-radius: 5px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
            <table class="table table-stripped">
                Monthly Report as of : {{$currentDate}}
                <thead>
                    <tr>
                        <th>URL</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mailMessage as $url)
                    <tr>
                        <td>{{$url->url}}</td>
                        <td>{{$url->status}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</body>
</html>