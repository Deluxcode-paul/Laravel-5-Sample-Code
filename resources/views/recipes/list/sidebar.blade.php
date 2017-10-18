{{ Form::open([
    'method'=>'GET',
    'url' => $currentUrl,
    'files' => true,
    'id' => 'js-list-form',
    'class' => 'form form-listing box js-list-form'
]) }}

    <div class="form-listing__title">
        @lang('recipes/list.sidebar_title')
    </div>

{{--     <style>
        .hidden {display:none;}
        .selected {font-weight: bold;}
    </style>
    <script>
        window.onload = function (){
            $(document).on('change', '.js-preference', function (){
                $('.preference-block').addClass('hidden');
                $('.preference-block-' + $(this).data('id')).removeClass('hidden');
                $('.js-preference').removeClass('selected');
                $(this).addClass('selected');
            });
        }
    </script> --}}

    @include('recipes.list.sidebar.preference')

    @include('recipes.list.sidebar.actions')

    @include('recipes.list.sidebar.ingredients')


    <div>

    <!-- we should uncheck all checkboxes which hidden now BEFORE submit -->

        <label>
        <input type="checkbox" name="{{$featured['key']}}" {{ !empty($featured['selected']) ? ' checked="checked" ' : ''}}>
            @lang('recipes/list.featured-title')
        </label>
        <br/>
        <br/>
    @include('recipes.list.sidebar.allergens')
    @include('recipes.list.sidebar.blessingTypes')
    @include('recipes.list.sidebar.diets')
    @include('recipes.list.sidebar.holidays')
    @include('recipes.list.sidebar.courses')
    @include('recipes.list.sidebar.cookTime')
    @include('recipes.list.sidebar.chefs')
    @include('recipes.list.sidebar.sources')
    @include('recipes.list.sidebar.cuisines')
    <br/>
    
    @include('recipes.list.sidebar.actions')

    </div>
{{ Form::close() }}