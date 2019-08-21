@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="panel-body">
                    @include('native.create.errors')
                    {!! Form::open(['url'=>Request::fullUrl(), 'class'=>'form-horizontal']) !!}
                    @include('native.create.form', ['buttonText' => 'Dodaj słowo'])
                    {!! Form::close() !!}
                </div>
                <a href="{{ URL::previous() }}" class="text-primary h4 col-md-offset-4 col-md-10"> &larr; Wróć do poprzedniej strony</a>
            </div>
        </div>
    </div>
@endsection
