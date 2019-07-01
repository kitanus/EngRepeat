<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?version=1" type="text/css" rel="stylesheet">

</head>
<body>
<header class="content-fluid">
    <nav class="navbar navbar-expand-lg">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route("test", ["format" => "eng"]) }}">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("dictionary") }}">Dictionary</a>
            </li>
            <li class="nav-item dropdown">

            </li>
        </ul>
    </nav>
</header>
<main class="content-fluid mt-3">
    <div class="row">
        <div class="col-md"></div>
        <div class="col-md"><h1 class="h1 text-center">Словарь</h1></div>
        <div class="col-md"></div>
    </div>
    <div class="row">
        <div class="col-md"></div>
        <div class="col-md">
            <form action="{{ route("dictionary") }}">
                <table class="table table-striped">
                    <tr>
                        <th>id</th>
                        <th>Слово</th>
                        <th>Перевод</th>
                    </tr>
                    @foreach($dictionaries as $dictionary)
                        <tr>
                            <td name="id[{{$loop->index}}]"><input type="text" value="{{ $dictionary->id }}"></td>
                            <td name="word[{{$loop->index}}]"><input type="text" value="{{ $dictionary->word }}"></td>
                            <td name="translate[{{$loop->index}}]"><input type="text" value="{{ $dictionary->translate }}"></td>
                        </tr>
                    @endforeach
                </table>
                <div class="row">
                    <div class="col-md"></div>
                    <input type="submit" class="col-md btn" name="action" value="Save">
                    <div class="col-md"></div>
                </div>
            </form>
        </div>
        <div class="col-md"></div>
    </div>
</main>
</body>
</html>

