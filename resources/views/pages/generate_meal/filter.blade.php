<div class="panel-body">
    {{ Form::open([
        'url' => route('generate-a-meal'),
        'method' => 'GET',
        'class' => 'form js-form form-filter',
        'id' => 'js-form-filter',
        'role' => 'form'
    ]) }}

    <div class="form-group">
        @lang('pages/generate_meal.labels.i_want_to_cook')
        {{ Form::select('category_id', $filter->get('categories'), $filterValues['category_id'], [
            'placeholder' => trans('pages/generate_meal.placeholders.categories')
        ]) }}
    </div>

    <div class="form-group">
        @lang('pages/generate_meal.labels.meal_that_only_takes')
        <div class="col-md-6">
            {{ Form::select('cook_time', $filter->get('cook_time'), $filterValues['cook_time'], [
                'placeholder' => trans('pages/generate_meal.placeholders.time')
            ]) }}
        </div>
        @lang('pages/generate_meal.labels.to_cook_and_have')
        @lang('pages/generate_meal.labels.choose_ingredients')
    </div>

    <div class="form-group">
        {{ Form::select('ingredients[1]',
            $filter->get('ingredients'),
            (array_key_exists(1, $filterValues['ingredients']) ? $filterValues['ingredients'][1] : ''), [
            'placeholder' => trans('pages/generate_meal.placeholders.ingredient'),
            'class' => 'js-select2'
        ]) }}
        {{ Form::select('ingredients[2]',
            $filter->get('ingredients'),
            (array_key_exists(2, $filterValues['ingredients']) ? $filterValues['ingredients'][2] : ''), [
            'placeholder' => trans('pages/generate_meal.placeholders.ingredient'),
            'class' => 'js-select2'
        ]) }}
        {{ Form::select('ingredients[3]',
            $filter->get('ingredients'),
            (array_key_exists(3, $filterValues['ingredients']) ? $filterValues['ingredients'][3] : ''), [
            'placeholder' => trans('pages/generate_meal.placeholders.ingredient'),
            'class' => 'js-select2'
        ]) }}
        {{ Form::select('ingredients[4]',
            $filter->get('ingredients'),
            (array_key_exists(4, $filterValues['ingredients']) ? $filterValues['ingredients'][4] : ''), [
            'placeholder' => trans('pages/generate_meal.placeholders.ingredient'),
            'class' => 'js-select2'
        ]) }}
        @lang('pages/generate_meal.labels.and')
        {{ Form::select('ingredients[5]',
            $filter->get('ingredients'),
            (array_key_exists(5, $filterValues['ingredients']) ? $filterValues['ingredients'][5] : ''), [
            'placeholder' => trans('pages/generate_meal.placeholders.ingredient'),
            'class' => 'js-select2'
        ]) }}
    </div>

    <div class="form-actions">
        <button type="submit" class="btn is-large is-brown">
            @lang('pages/generate_meal.buttons.generate_meals')
        </button>
    </div>


    {{ Form::close() }}
</div>
