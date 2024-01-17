<html>
    <body>@if(isset(cache("site_settings")["google_tag_body"])) {!!cache("site_settings")["google_tag_body"]!!}@endif
        <div>
             {!! $mailData->content !!}
        </div>
    </body>
</html>



