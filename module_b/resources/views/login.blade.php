<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link rel="stylesheet" href="{{asset("css/main.css")}}">
</head>
<body>
<div class="wrapper">
    <form action="/login" method="POST">
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
