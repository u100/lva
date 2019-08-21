<div class="form-group">
<div class="col-md-4 col-md-offset-2 control-label h4">Zmiana hasła</div>
</div>
<div class="form-group">
    <div class="col-md-4 control-label">
        {!! Form::label('current_password', 'Aktualne hasło:') !!}
    </div>
    <div class="col-md-2">
        {!! Form::password('current_password') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4 control-label">
        {!! Form::label('password', 'Nowe hasło:') !!}
    </div>
    <div class="col-md-4">
        {!! Form::password('password') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4 control-label">
        {!! Form::label('password_repeat', 'Powtórz nowe hasło:') !!}
    </div>
    <div class="col-md-4">
        {!! Form::password('password_repeat') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4 col-md-offset-7">
        {!! Form::submit($buttonText, ['class'=>'btn btn-primary']) !!}
    </div>
</div>