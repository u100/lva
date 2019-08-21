@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="card">
            <div class="panel-body">
                @include('singlelist.edit.errors')
                {!! Form::open(['url'=>'singlelist', 'class'=>'form-horizontal']) !!}
                @include('singlelist.edit.form', ['buttonText' => 'Dodaj listę'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

