@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="panel-body">
                    @if(Session::has('passwordsNotTheSame'))
                        <div class="alert alert-danger card">
                            {{ Session::get('passwordsNotTheSame') }}
                        </div>
                    @endif
                    @if(Session::has('passwordsIncorrect'))
                        <div class="alert alert-danger card">
                            {{ Session::get('passwordsIncorrect') }}
                        </div>
                    @endif
                    @include('settings.editPassword.errors')
                    {!! Form::model($editedPassword, ['method'=>'PATCH', 'class'=>'form-horizontal', 'action' => ['SettingsController@updatePassword', $editedPassword->id]]) !!}
                    @include('settings.editPassword.form', ['buttonText' => 'Zapisz zmiany'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection