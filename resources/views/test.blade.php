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
                    <a class="nav-link" href="{{ route("test", ["format" => $format]) }}">Home<span class="sr-only">(current)</span></a>
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
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="row">
                    <a href="{{ route("test", ["format" => "eng"]) }}" class="btn btn-primary col-md col-sm ml-1 mr-1">Англ.</a>
                    <a href="{{ route("test", ["format" => "rus"]) }}" class="btn btn-primary col-md col-sm ml-1 mr-1">Рус.</a>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row">
            <div class="col-md" ></div>
            <div class="col-md">
                <form method="post" action="{{ route("test", ["format" => $format]) }}">
                    {{ csrf_field() }}
                    <table class="table table-striped" >
                        <tr>
                            <th colspan="4" class="text-center">Table</th>
                        </tr>
                        <tr>
                            <td>Слово</td>
                            <td>Перевод</td>
                            <td>Значение</td>
                            <td>Статус</td>
                        </tr>
                        @foreach($words as $word)
                            <tr>
                                <td>{{ $word->word }}</td>
                                <td>
                                    <input type="text" name="answer[{{ $loop->index }}]"
                                           value="{{ (!empty($lastAnswer)) ? $lastAnswer[$loop->index] : "" }}"
                                    >
                                </td>
                                @if($post !== NULL)
                                    <td>{{ $word->translate }}</td>
                                    <td>{{ $status[$loop->index]->win-$status[$loop->index]->lose }}</td>
                                @else
                                    <td></td>
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                    <div class="row" >
                        <div class="col-md-4"></div>
                        <input type="submit" class="btn btn-primary col-md-4 mt-1 mb-1" name="go" value="Отправить">
                        <div class="col-md-4"></div>
                    </div>
                </form>

            </div>
            <div class="col-md" ></div>
        </div>
    </main>
</body>
</html>
