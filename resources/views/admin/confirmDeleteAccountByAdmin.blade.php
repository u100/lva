@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading h3">Potwierdzenie usunięcia konta</div>
                    <div class="panel-body">
                        <div>
                            <div class="h4">
                                Czy na pewno chcesz usunąć swoje konto? Wszystkie dane tego konta: listy słów, słowa wraz z ich tłumaczeniami oraz wszystkie wyniki zostaną bezpowrotnie usunięte.
                            </div>
                            <div>&nbsp;</div>
                            <div class="text-center" style="margin-top: 8px"><a href="{{ URL::previous() }}" class="btn btn-success">Nie usuwaj, zabierz mnie stąd</a></div>
                            <div>&nbsp;</div>
                            <div class="text-center" style="margin-top: 8px"><a href="{{ action('AdminController@deleteAccountByAdmin', key($_GET)) }} " class="btn btn-danger">Tak, usuń konto</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection