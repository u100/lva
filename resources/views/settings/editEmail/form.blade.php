<div class="form-group">
<div class="col-md-4 col-md-offset-2 control-label h4">Edycja adresu email</div>
</div>
<div class="form-group">
    <div class="col-md-4 control-label">
        {!! Form::label('email', 'Email:') !!}
    </div>
    <div class="col-md-4">
        {!! Form::text('email', null, ['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4 col-md-offset-7">
        {!! Form::submit($buttonText, ['class'=>'btn btn-primary']) !!}
    </div>
</div>