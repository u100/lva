<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading h3">Słówka na liście</div>
                    <div class="panel-body">

                        @if(Session::has('successWordRemoval'))
                            <div class="alert alert-success card">
                                {{ Session::get('successWordRemoval') }}
                            </div>
                        @endif

                        @if(Session::has('failWordRemoval'))
                            <div class="alert alert-danger card">
                                {{ Session::get('failWordRemoval') }}
                            </div>
                        @endif

                        @if(Session::has('successNativeOrForeignWordSave'))
                            <div class="alert alert-success card">
                                {{ Session::get('successNativeOrForeignWordSave') }}
                            </div>
                        @endif

                        @if(Session::has('failNativeOrForeignWordSave'))
                            <div class="alert alert-danger card">
                                {{ Session::get('failNativeOrForeignWordSave') }}
                            </div>
                        @endif

                        @if(Session::has('noWordsOntheList'))
                            <div class="alert alert-info card">
                                {{ session()->pull('noWordsOntheList') }}
                                {{ session()->forget('noWordsOntheList') }}
                            </div>
                        @endif

                        @if($nativeWords->count())
                            <div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <caption><b><h3>{{$singlelist->name}}</h3></b></caption>
                                        <th>polski</th>
                                        <th>{{$languageName}}</th>
                                        <th>Nauczone?</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $displayedFlagWithButtonStatus = 0;?>
                                    @foreach($nativeWords as $native)
                                        @if($displayedFlagWithButtonStatus == 0)
                                            <div class=" col-md-offset-6">
                                                <button type="button" class="btn btn-primary" onclick="window.location.href='{{route('setRoute', ['lang_id' => $singlelist->language_id, 'list_id' => $singlelist->id])}}'">Ucz się słówek z listy</button>
                                                <img src="{{url('/flags/'.$native->vocabulary_list->language->flag_link.'.png')}}" alt="Image" class="col-md-offset-1" style="outline: 1px solid gray" />
                                            </div>
                                            <?php $displayedFlagWithButtonStatus = 1; ?>
                                        @endif

                                        @foreach($native->foreign_words as $foreign)
                                        <tr>
                                            <td><div class="text-primary"><strong>{{$native->word}}</strong></div></td>
                                            <td><div class="text-primary"><strong>{{$foreign->word}}</strong></div></td>
                                            <td><div><?php if($native->success == 0 || $foreign->success == 0)
                                                                print('<div class="text-muted">Nie</div>');
                                                            elseif($native->success == 1 && $foreign->success == 1)
                                                                print('<div class="text-success">Tak</div>'); ?>
                                                </div></td>
                                            <?php $deletedWordsIDs = $native->id.'-'.$foreign->id?>
                                            <td><a href="{{ action('SingleWordController@deleteWord', $deletedWordsIDs) }}"><span class="glyphicon glyphicon-trash"></span></a></td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-warning btn-block" onclick="window.location.href='{{route('createNative', ['lang_id' => $singlelist->language_id, 'list_id' => $singlelist->id])}}'">Dodaj polskie słowo</button>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-success btn-block" onclick="window.location.href='{{route('createForeign', ['lang_id' => $singlelist->language_id, 'list_id' => $singlelist->id])}}'">Dodaj {{$languageName.'e'}} słowo</button>
                                        </div>
                                    </div>
                                </div>
                        @else
                            <h4>Nie dodałeś jeszcze żadnego słowa do tej listy.</h4>
                            <br/>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-3"><button type="button" class="btn btn-warning btn-block" onclick="window.location.href='{{route('createNative', ['lang_id' => $singlelist->language_id, 'list_id' => $singlelist->id])}}'">Dodaj polskie słowo</button></div>
                                            <div class="col-sm-1"></div>
                                            <div class="col-sm-3"><button type="button" class="btn btn-success btn-block" onclick="window.location.href='{{route('createForeign', ['lang_id' => $singlelist->language_id, 'list_id' => $singlelist->id])}}'">Dodaj {{$languageName.'e'}} słowo</button></div>
                                        </div>
                                    </div>
                        @endif
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

