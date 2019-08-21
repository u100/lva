@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="card">
                <div class="panel-body">
                    @include('learningforeign.edit.errors')

                    @if(Session::has('wordLearned'))
                        <div class="alert alert-success card">
                            {{ session()->pull('wordLearned') }}
                            {{ session()->forget('wordLearned') }}
                        </div>
                    @endif

                    @if(Session::has('successAttempt'))
                        <div class="alert alert-success card">
                            {{ session()->pull('successAttempt') }}
                            {{ session()->forget('successAttempt') }}
                        </div>
                    @endif

                    @if(Session::has('failAttempt'))
                        <div class="alert alert-danger card">
                            {{ session()->pull('failAttempt') }}
                            {{ session()->forget('failAttempt') }}
                        </div>
                    @endif

                    @if($generatedWord->native_to_foreign_status !== false && $generatedWord->native_to_foreign_status == 0)
                        <div class="container">
                            <div class="row">
                                <div class="col-md-2"><img src="{{url('/flags/'.$generatedWord->vocabulary_list->language->flag_link.'.png')}}" alt="Image" style="outline: 1px solid gray" /></div>
                                <div class="col-md-2"><img src="{{url('/graphics/direction.png')}}" alt="Image" /></div>
                                <div class="col-md-2"><img src="{{url('/graphics/polski.png')}}" alt="Image" style="outline: 1px solid gray" /></div>
                            </div>
                            <div class="row">
                                <div class="col-md-10" style="margin-top:40px; margin-left:-180px">
                                    {!! Form::model($generatedWord, ['method'=>'PATCH', 'class'=>'form-horizontal', 'action' => ['LearningForeignWordsController@checkWord']]) !!}
                                    @include('learningforeign.edit.form', ['buttonText' => 'Tłumacz'])
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                    @elseif($generatedWord->native_to_foreign_status !== false && $generatedWord->native_to_foreign_status == 1)
                        <div class="container">
                            <div class="row">
                                <div class="col-md-2"><img src="{{url('/graphics/polski.png')}}" alt="Image" style="outline: 1px solid gray" /></div>
                                <div class="col-md-2"><img src="{{url('/graphics/direction.png')}}" alt="Image" /></div>
                                <div class="col-md-2"><img src="{{url('/flags/'.$generatedWord->vocabulary_list->language->flag_link.'.png')}}" alt="Image" style="outline: 1px solid gray" /></div>
                            </div>
                            <div class="row">
                                <div class="col-md-10" style="margin-top:40px; margin-left:-180px">
                                    {!! Form::model($generatedWord, ['method'=>'PATCH', 'class'=>'form-horizontal', 'action' => ['LearningForeignWordsController@checkWord']]) !!}
                                    @include('learningforeign.edit.form', ['buttonText' => 'Tłumacz'])
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection