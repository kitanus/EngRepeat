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
    <div class="row mt-2 mb-2">
        <div class="col-md"></div>
        <button class="btn-success col-md">Сохранить</button>
        <div class="col-md"></div>
    </div>
</form>
