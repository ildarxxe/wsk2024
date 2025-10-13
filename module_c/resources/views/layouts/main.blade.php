<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield("meta_tags")
    <title>@yield("title")</title>
    <link rel="stylesheet" href="{{asset("css/main.css")}}">
    @yield("style")
</head>
<body>
@if(session("error"))
    <div class="error">
        <p>{{session("error")}}</p>
    </div>
@endif
<form class="search-form">
    <input placeholder="Search by tags" id="tag" type="text">
    <button type="submit">Search</button>
</form>
@yield("content")
</body>
<script>
    const form = document.forms[0];
    const tagInput = document.querySelector('#tag');

    form.addEventListener("submit", (e) => {
        e.preventDefault();
        const tag = tagInput.value;

        window.location.href = `/01_module_C/heritages/tags/${tag}`
    })
</script>
</html>
