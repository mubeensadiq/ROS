<!DOCTYPE html>
<html lang="en" class="theme-3 dark">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ env('APP_NAME', 'Pizza Xpress') }}</title>
    @vite(['resources/js/app.js'])
</head>
<body>
<div id="app"></div>
</body>
<script type="text/javascript">
    window.vapid_public_key = "{{env('vapid_public_key')}}";
    @auth
        window.Permissions = {!! json_encode(Auth::user()->allPermissions, true) !!};
    @else
        window.Permissions = [];
    @endauth
</script>
{{--<script> !function() { var t; if (t = window.webbot = window.webbot = window.webbot || [], !t.init) return t.invoked ? void (window.console && console.error && console.error("Snippet included twice.")) : ( t.load =function(e){ var o,n; o=document.createElement("script"); e.type="text/javscript"; o.async=!0; o.crossorigin="anonymous"; o.src="https://app.botsify.com/web-bot/script/frame/"+e+"/webbot.js"; n=document.getElementsByTagName("script")[0]; n.parentNode.insertBefore(o,n); }); }(); webbot.load('prbBgdgSmgi3koqcRgEEY4aWR5CZz9jrwb9nbhNF'); </script>--}}
</html>
