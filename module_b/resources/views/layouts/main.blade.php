<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield("title")</title>
    <link rel="stylesheet" href="{{asset("css/main.css")}}">
    @yield("css")
</head>
<body>
<header>
    <nav>
        <a href="/products">Products</a>
        <a href="/companies">Companies</a>
        <a href="/checker">Checker GTIN</a>
    </nav>
</header>
    @if(session("error"))
        <div class="error">
            <p>{{session("error")}}</p>
        </div>
    @endif

    @if(session("success"))
        <div class="message">
            <p>{{session("success")}}</p>
        </div>
    @endif

    @if(session("message"))
        <div class="message">
            <p>{{session("message")}}</p>
        </div>
    @endif

    @yield("content")
</body>
@yield("script")
</html>
