<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset("css/login.css")}}">
    <link rel="stylesheet" href="{{asset("css/main.css")}}">
</head>
<body>
    <div class="login_wrapper">
            @if(session("error"))
                <div class="errors">
                    <p>{{session('error')}}</p>
                </div>
            @endif
        <form class="login" method="POST" action="/login">
            @csrf
            <div class="form_label">
                <label for="password">Password:</label>
                <input type="text" name="password" id="password">
            </div>
            <div class="form_button">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
