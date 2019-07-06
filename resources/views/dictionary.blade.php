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
        <div class="col-md"><h2 class="h2 text-center">Создать записи</h2></div>
        <div class="col-md"></div>
    </div>
    <div class="row">
        <div class="col-md"></div>
        <div class="col-md">
            @if(empty($counts))
            <form class="container-fluid" action="{{ route("dictionary.new") }}" method="post">
                {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md"><p class="align-middle" style="line-height: 40px;">Сколько записей:</p></div>
                        <input type="text" class="col-md" name="count">
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md"></div>
                        <button class="btn col-md">Создать</button>
                        <div class="col-md"></div>
                    </div>
            </form>
            @else
                <form class="container-fluid" action="{{ route("dictionary.record") }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md"><p>Слово</p></div>
                        <div class="col-md-1"></div>
                        <div class="col-md"><p>Перевод</p></div>
                        <div class="col-md-1"></div>
                    </div>
                    @for($i=0; $i<$counts; $i++)
                        <div class="row">
                            <div class="col-md-1"></div>
                            <input type="text" class="col-md" name="word[{{ $i }}]">
                            <div class="col-md-1"></div>
                            <input type="text" class="col-md" name="translate[{{ $i }}]">
                            <div class="col-md-1"></div>
                        </div>
                    @endfor
                    <div class="row">
                        <div class="col-md"></div>
                        <button class="btn col-md">Сохранить</button>
                        <div class="col-md"></div>
                    </div>
                </form>
            @endif
        </div>
        <div class="col-md"></div>
    </div>
    <div class="row">
        <div class="col-md"></div>
        <div class="col-md"><h2 class="h2 text-center">Изменение словаря</h2></div>
        <div class="col-md"></div>
    </div>
    <div class="row">
        <div class="col-md"></div>
        <div class="col-md">
            <form action="{{ route("dictionary.update") }}" method="post">
                {{ csrf_field() }}
                <table class="table table-striped">
                    <tr>
                        <th>id</th>
                        <th>Слово</th>
                        <th>Перевод</th>
                        <th></th>
                    </tr>
                    @foreach($dictionaries as $dictionary)
                        <tr>
                            <td><input type="text" name="id[{{$loop->index}}]" value="{{ $dictionary->id }}"></td>
                            <td><input type="text" name="word[{{$loop->index}}]" value="{{ $dictionary->word }}"></td>
                            <td><input type="text" name="translate[{{$loop->index}}]" value="{{ $dictionary->translate }}"></td>
                            <td><a href="{{ route("dictionary.delete") }}?id={{ $dictionary->id }}">Удалить</a></td>
                        </tr>
                    @endforeach
                </table>
                <div class="row">
                    <div class="col-md"></div>
                    <button class="col-md btn">Сохранить</button>
                    <div class="col-md"></div>
                </div>
            </form>
        </div>
        <div class="col-md"></div>
    </div>
</main>
</body>
</html>

