<div class="form-group">
<div class="col-md-4 col-md-offset-3 control-label h4">Zmiana hasła</div>
</div>
<div class="form-group">
    <div class="col-md-6 control-label">
        {!! Form::label('password', 'Nowe hasło:') !!}
    </div>
    <div class="col-md-6">
        {!! Form::password('password') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 control-label">
        {!! Form::label('password_repeat', 'Powtórz nowe hasło:') !!}
    </div>
    <div class="col-md-6">
        {!! Form::password('password_repeat') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4 col-md-offset-6">
        {!! Form::submit($buttonText, ['class'=>'btn btn-primary']) !!}
    </div>
</div>