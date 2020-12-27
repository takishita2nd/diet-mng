<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ダイエット管理</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="flex-center position-ref">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    ダイエット管理ツール
                </div>
                <div id="whatsthis">
                    <h1>このツールでできること</h1>
                    <h2>毎日計測した体重、体脂肪、BMIを記録することができます。</h2>
                    <p>日々の記録の変化がグラフで確認することができます。</p>
                    <img id="graph" src="figure1.png"/>
                    <h2>登録・ご利用は無料です。どなたでもご利用いただけます。</h2>
                </div>
            </div>
        </div>
    </body>
</html>
