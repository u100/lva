@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="panel-body">
                    @include('settings.editEmail.errors')
                    {!! Form::model($editedEmail, ['method'=>'PATCH', 'class'=>'form-horizontal', 'action' => ['SettingsController@updateEmail', $editedEmail->id]]) !!}
                    @include('settings.editEmail.form', ['buttonText' => 'Zapisz zmiany'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
