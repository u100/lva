@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="card">
            <div class="panel-body">
                @include('singlelist.edit.errors')
                {!! Form::model($editedlist, ['method'=>'PATCH', 'class'=>'form-horizontal', 'action' => ['SingleListController@update', $editedlist->id]]) !!}
                @include('singlelist.edit.form', ['buttonText' => 'Zapisz zmiany'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection