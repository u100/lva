<div class="form-group">
    <div class="col-md-4 control-label">
        {!! Form::label('toTranslate', 'Słowo:') !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('toTranslate', $generatedWord->word, ['class'=>'form-control', 'readonly' => 'true']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        {{ Form::hidden('vocabulary_list_id', $list_id) }}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4 control-label">
        {!! Form::label('word', 'Tłumaczenie:') !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('word', '', ['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        {{ Form::hidden('pattern', $generatedWord->pattern) }}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        {{ Form::hidden('native_to_foreign_status', $generatedWord->native_to_foreign_status) }}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        {{ Form::hidden('word_repeating_counter', $generatedWord->word_repeating_counter) }}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        {{ Form::hidden('success', $generatedWord->success) }}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4">
        {{ Form::hidden('word_id', $generatedWord->id) }}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4 col-md-offset-5" style="margin-top:-40px">
        {!! Form::submit($buttonText, ['class'=>'btn btn-primary']) !!}
    </div>
</div>
<a class="navbar-brand"></a><a class="navbar-brand"></a><a class="navbar-brand"></a><a class="navbar-brand"></a>
<a href="{{ action('SingleListController@show', $generatedWord->vocabulary_list_id) }}" class="text-primary h4 col-md-offset-4 col-md-10"> &larr; Wróć do poprzedniej strony</a>