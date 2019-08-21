@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading h3">Twoje listy słówek</div>
                    <div class="panel-body">
                    @if(Session::has('resetConfirmation'))
                        <div class="alert alert-success card">
                            {{ Session::get('resetConfirmation') }}
                        </div>
                    @endif

                    @if(Session::has('wordListEmptyMessage'))
                        <div class="alert alert-info card">
                            {{ Session::get('wordListEmptyMessage') }}
                        </div>
                    @endif

                    @if(Session::has('notAdmin'))
                        <div class="alert alert-danger card">
                            {{ Session::get('notAdmin') }}
                        </div>
                    @endif

                    @if(Session::has('successListRemoval'))
                        <div class="alert alert-success card">
                            {{ Session::get('successListRemoval') }}
                        </div>
                    @endif

                    @if(Session::has('failListRemoval'))
                        <div class="alert alert-danger card">
                            {{ Session::get('failListRemoval') }}
                        </div>
                    @endif
                    @if($mylists->count())
                            <div>
                                <table class="table">
                                    <tbody>
                                        @foreach($mylists as $mylist)
                                        <tr>
                                            <th scope="row">
                                            </th>
                                            <td><div><img src="{{url('/flags/'.$mylist->language->flag_link.'.png')}}" alt="Image" style="outline: 1px solid gray"/></div></td>
                                            <td><div class="text-center h4" style="margin-top: 8px"><a href="{{ action('SingleListController@show', $mylist->id) }}">{{$mylist->name}}</a></div></td>
                                            <td><div class="text-center" style="margin-top: 8px"><a href="{{ action('SingleListController@edit', $mylist->id) }}" class="btn btn-info">Edytuj</a></div></td>
                                            <td><div class="text-center" style="margin-top: 8px"><a href="{{ action('SingleListController@resetResults', $mylist->id) }}" class="btn btn-primary">Wyzeruj wyniki</a></div></td>
                                            <td><div class="text-center" style="margin-top: 8px"><a href="{{ action('SingleListController@generatePDF', $mylist->id) }}" class="btn btn-warning">PDF</a></div></td>
                                            <td><div class="text-center" style="margin-top: 8px"><a href="{{ action('SingleListController@generateCSV', $mylist->id) }}" class="btn btn-success">CSV</a></div></td>
                                            <td><div class="text-center" style="margin-top: 8px"><a href="{{ action('SingleListController@deleteList', $mylist->id) }}" class="btn btn-danger">Usuń</a></div></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary" onclick="window.location.href='{{route('createlist')}}'">Utwórz nową listę</button>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    @if($adminPanelAccessLink === 1)
                                        <button type="button" class="btn btn-muted" onclick="window.location.href='{{route('admin')}}'">Przejdź do panelu administratora</button>
                                    @endif
                            </div>
                    @else
                        <h4>Nie dodałeś jeszcze żadnej listy.</h4>
                        <br/>
                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{route('createlist')}}'">Utwórz nową listę</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            @if($adminPanelAccessLink === 1)
                                <button type="button" class="btn btn-muted" onclick="window.location.href='{{route('admin')}}'">Przejdź do panelu administratora</button>
                            @endif
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection