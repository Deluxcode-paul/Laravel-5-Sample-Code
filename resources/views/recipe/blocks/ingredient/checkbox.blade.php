{{ Form::hidden("Ingredient[$ingredient->id]", '0') }}
<label class="form-checkbox">
    {{ Form::checkbox("Ingredient[$ingredient->id]", $ingredient->id, false, ['class' => 'js-ingredient-ckb'])}}
    <span class="form-checkbox__icon">
        @include('partials.icons.icon-check')
    </span>
    <span class="form-checkbox__title">{!! $ingredient->description !!}</span>
</label>