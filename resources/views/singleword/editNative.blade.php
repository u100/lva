@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="panel-body">
                    @include('singleword.edit.errors')
                    {!! Form::model($editedNativeWord, ['method'=>'PATCH', 'class'=>'form-horizontal', 'action' => ['SingleWordController@updateNative', $editedNativeWord->id]]) !!}
                    @include('singleword.edit.form', ['buttonText' => 'Zapisz zmiany'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
