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
<div class="flex-center position-ref full-height">

    <div class="content-fluid mt-3">
        <div class="row">
            <div class="col-md-4" ></div>
            <div class="col-md-4" >
                <form method="post" action="{{ route("check") }}">
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
                                    <input type="text" name="order[{{ $loop->index }}]"
                                           value="{{ ($post !== NULL) ? $lastAnswer[$loop->index] : "" }}"
                                    >
                                </td>
                                @if($post !== NULL)
                                    <td>{{ $word->translate }}</td>
                                    <td>{{ $word->win-$word->lose }}</td>
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
                <div class="row" >
                    <div class="col-md-4"></div>
                    <a href="{{ route("check") }}" class="btn btn-primary col-md-4 mt-1 mb-1">Заново</a>
                    <div class="col-md-4"></div>
                </div>

            </div>
            <div class="col-md-4" ></div>
        </div>
    </div>
</div>
</body>
</html>
