@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="panel-body">
                    @if(Session::has('passwordsIncorrect'))
                        <div class="alert alert-danger card">
                            {{ Session::get('passwordsIncorrect') }}
                        </div>
                    @endif
                    @include('admin.editPassword.errors')
                    {!! Form::model($editedPassword, ['method'=>'PATCH', 'class'=>'form-horizontal', 'action' => ['AdminController@updatePasswordByAdmin', $editedPassword->id]]) !!}
                    @include('admin.editPassword.form', ['buttonText' => 'Zapisz'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection