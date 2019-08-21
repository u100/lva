<div class="form-group">
    <div class="col-md-4 control-label">
        {!! Form::label('word', 'Słowo:') !!}
    </div>
    <div class="col-md-4">
        {!! Form::text('word', null, ['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4 col-md-offset-7">
        {!! Form::submit($buttonText, ['class'=>'btn btn-primary']) !!}
    </div>
</div>