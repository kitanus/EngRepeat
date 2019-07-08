@extends('main')

@section('title', "Словарь")

@section('content')
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
                    <div class="row mt-2 mb-2">
                        <div class="col-md"></div>
                        <button class="btn-success col-md">Создать</button>
                        <div class="col-md"></div>
                    </div>
            </form>
            @else
                @include('parts.create')
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
                <div class="row mt-2 mb-2">
                    <div class="col-md"></div>
                    <button class="col-md btn-success">Сохранить</button>
                    <div class="col-md"></div>
                </div>
            </form>
        </div>
        <div class="col-md"></div>
    </div>
    <div class="row">
        <div class="col-md"></div>
        <div class="col-md"><h2 class="h2 text-center">Сброс результатов</h2></div>
        <div class="col-md"></div>
    </div>
    <div class="row">
        <div class="col-md"></div>
        <div class="col-md">
            <form action="{{ route("dictionary.reset") }}">
                <div class="row">
                    <div class="col-md"></div>
                    <select name="table">
                        <option value="rus_to_eng">Руско-английский словарь</option>
                        <option value="eng_to_rus">Английско-русский словарь</option>
                    </select>
                    <div class="col-md"></div>
                </div>
                <div class="row mt-2 mb-5">
                    <div class="col-md"></div>
                    <button class="col-md btn-success">Сбросить</button>
                    <div class="col-md"></div>
                </div>
            </form>
        </div>
        <div class="col-md"></div>
    </div>
@endsection

