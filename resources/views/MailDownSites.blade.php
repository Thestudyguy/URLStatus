<html>

<head>
</head>

<body style="color: white;">
    <div class="card-body" style="width: fit-content;
    padding: 3em;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(45deg, #2D4A53 60%, #2D4A53 33%, #132E35 33%, #132E35 66%, #0D1F43 66%, #0D1F43 100%); 
    box-shadow: 1px 2px 9px 0px rgba(0, 0, 0, 0.75);  
    -webkit-box-shadow: 1px 2px 9px 0px rgba(0, 0, 0, 0.75); 
    -moz-box-shadow: 1px 2px 9px 0px rgba(0, 0, 0, 0.75);">
        <div class="">
            <table class="table table-stripped">
                <thead>
                    <tr>
                        <th>URL</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="" style="color: whitesmoke;">{{($URLstatus)}}</a></td>
                    </tr>

                </tbody>
            </table>
        </div>
        <br>
        <div>
            {{$currentDate}}
        </div>
    </div>
</body>

</html>