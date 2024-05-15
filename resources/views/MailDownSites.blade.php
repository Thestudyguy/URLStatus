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
                        {{($url)}}
                        Status went from {{$oldStatus}} to {{($status)}}
        </div>
        <br>
        <div>
            {{$currentDate}}
        </div>
       <footer>
       MediOne PH <img src="http://localhost:8000/images/logo.png" alt="">
       </footer>
    </div>
</body>

</html>