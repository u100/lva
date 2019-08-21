<div class="form-group">
<div class="col-md-4 col-md-offset-2 control-label h4">Lista</div>
</div>
<div class="form-group">
    <div class="col-md-4 control-label">
        {!! Form::label('name', 'Tytuł:') !!}
    </div>
    <div class="col-md-4">
        {!! Form::text('name', null, ['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4 control-label">
        {!! Form::label('language_id', 'Język obcy:') !!}
    </div>
    <div class="col-md-4">
        {!! Form::select('language_id', $languages) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        {{ Form::hidden('user_id', Auth::id()) }}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        {{ Form::hidden('general_repeating_counter', 0) }}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        {{ Form::hidden('active', 1) }}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4 col-md-offset-7">
        {!! Form::submit($buttonText, ['class'=>'btn btn-primary']) !!}
    </div>
</div>