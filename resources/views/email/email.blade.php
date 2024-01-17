<html>
    <body>
        <div>
            <div class = "bld_title">
                <h1>{{$mailData->title}}</h1>
            </div>
            <p>Email Type: {{$mailData->type}}</p>
            <p>Name: {{$mailData->from_name}}</p>
            <p>Email: {{$mailData->from_email}}</p>
            <br>
            <p>Message: {!! $mailData->content !!}</p>
        </div>
    </body>
</html>



