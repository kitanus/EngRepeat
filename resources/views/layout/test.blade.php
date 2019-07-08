@extends('main')

@section('title', "Тест")

@section('content')
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="row">
                <a href="{{ route("eng.test") }}" class="btn btn-primary col-md col-sm ml-1 mr-1">Англ.</a>
                <a href="{{ route("rus.test") }}" class="btn btn-primary col-md col-sm ml-1 mr-1">Рус.</a>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="row">
        <div class="col-md" ></div>
        <div class="col-md">
            <form method="post" action="{{ route($format.".test") }}">
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

        </div>
        <div class="col-md" ></div>
    </div>
@endsection
