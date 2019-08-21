@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading h3">Statystyki</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8">
                        <div class="row">
                            <div class="col-lg-6 col-md-9">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-comments fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-left">
                                                <div class="huge"><b>{{$totalStats[0]}}</b></div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="panel-footer">
                                            <span class="pull-left">Łączna liczba użytkowników</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                </div>
                            </div>
                        </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-9">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-comments fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 text-left">
                                                        <div class="huge"><b>{{$totalStats[1]}}</b></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-footer">
                                                <span class="pull-left">Łączna liczba powtórzeń</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-9">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-comments fa-5x"></i>
                                            </div>
                                            <div class="col-xs-offset-2 col-xs-10 text-right">
                                                <?php $nr = 1 ?>
                                                @foreach($usersRating as $key => $value)
                                                    <span class="pull-left">{{ $nr.'. '}}<b>{{$key}}</b>{{': '.$value.' powt.' }}<?php $nr++; ?></span><br/>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                        <div class="panel-footer">

                                            <span class="pull-left">Najaktywniejsi użytkownicy</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                </div>
                            </div>
                        </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-9">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-comments fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-offset-2 col-xs-10 text-right">
                                                        <?php $nr = 1 ?>
                                                        @foreach($languagesStats as $key => $value)
                                                            <span class="pull-left">{{ $nr.'. '}}<b>{{$key}}</b>{{': '.$value.' powt.' }}<?php $nr++; ?></span><br/>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-footer">
                                                <span class="pull-left">Słówka według języków</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-comments fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 text-left">
                                                        <div class="huge"><h4>{{$mainStats[0].' / '.$mainStats[1][0].' / '}}<b>{{$mainStats[1][1]}}</b></h4></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-footer">
                                                <span class="pull-left">Liczba Twoich powtórzeń:<br />– w ostatnim roku<br />– 30dniach<br /><b>– dzisiaj</b></span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-comments fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 text-left">
                                                        <div><b>{{$mainStats[2][0]}}</b>{{': '.$mainStats[2][1].' powt.'}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-footer">
                                                <span class="pull-left">Tabela z największą liczbą wszystkich powtórzeń</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <i class="fa fa-comments fa-5x"></i>
                                                    </div>
                                                    <div class="col-xs-9 text-left">
                                                        <div><b>{{$mainStats[2][2]}}</b>{{': '.$mainStats[2][3].' powt.'}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-footer">
                                                <span class="pull-left">Tabela z największą liczbą poprawnych powtórzeń</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ URL::previous() }}" class="text-primary h4">Wróć do poprzedniej strony</a>
            </div>
        </div>
    </div>
@endsection