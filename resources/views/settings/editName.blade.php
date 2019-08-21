@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="panel-body">
                    @include('settings.editName.errors')
                    {!! Form::model($editedName, ['method'=>'PATCH', 'class'=>'form-horizontal', 'action' => ['SettingsController@updateName', $editedName->id]]) !!}
                    @include('settings.editName.form', ['buttonText' => 'Zapisz zmiany'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
