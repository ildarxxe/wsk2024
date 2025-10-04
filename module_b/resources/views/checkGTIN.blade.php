<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Check GTIN</title>
    <link rel="stylesheet" href="{{asset('css/checker.css')}}">
</head>
<body>
    <div class="checker_wrapper">
        @if(session("result"))
            @php
                $allValid = true;
                foreach (session("result") as $item) {
                    if (!$item[1]) {
                        $allValid = false;
                        break;
                    }
                }
            @endphp
        @endif

        @if(session("result") && $allValid)
            <div class="success-overlay">
                <div class="success-banner">
                    <h2>Все GTIN-коды валидны!</h2>
                    <p>Проверка завершена успешно.</p>
                </div>
            </div>
        @endif
        <form class="checker" method="POST" action="/checker">
            @csrf
            <div class="checker_inner">
                <div class="form_label">
                    <label for="GTIN_1">GTIN 1:</label>
                    <input type="text" name="GTIN_1" id="GTIN_1">
                </div>
            </div>
            <button class="add" type="button">Add</button>
            <div class="check">
                <button type="submit">Check</button>
            </div>
        </form>
        @if(session("result"))
            <div class="result">
                @foreach(session("result") as $item)
                    <div class="result_box">
                        <p class="GTIN">Код: {{$item[0]}}</p>
                        <h1 class="exist {{ $item[1] ? 'true' : 'false' }}">
                            @if($item[1])
                                Существует
                            @else
                                Не существует
                            @endif
                        </h1>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
<script src="{{asset('js/checker.js')}}"></script>
</html>
