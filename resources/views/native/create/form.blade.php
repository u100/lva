<div class="form-group">
<div class="col-md-4 col-md-offset-2 control-label h3">Tłumaczenia polskiego słówka</div>
</div>
{!! Form::hidden('vocabulary_list_id', $list_id) !!}
{!! Form::hidden('pattern', '2222') !!}
{!! Form::hidden('native_to_foreign_status', 1) !!}
{!! Form::hidden('word_repeating_counter', 0) !!}
{!! Form::hidden('success', 0) !!}
<div class="form-group">
    <div class="col-md-4 control-label">
        {!! Form::label('word', 'Słowo *') !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('word',null,['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div  class="col-md-4 control-label">
        {!! Form::label('first_translation','Tłumaczenie 1 *') !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('first_translation',null,['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div  class="col-md-4 control-label">
        {!! Form::label('second_translation','Tłumaczenie 2') !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('second_translation',null,['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div  class="col-md-4 control-label">
        {!! Form::label('third_translation','Tłumaczenie 3') !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('third_translation',null,['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-offset-5">
        {!! Form::submit($buttonText,['class'=>'btn btn-warning']) !!}
    </div>
</div>