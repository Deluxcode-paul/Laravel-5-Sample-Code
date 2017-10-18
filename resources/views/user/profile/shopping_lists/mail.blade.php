<h1>@lang('user/profile.pdf.shopping_list')</h1>
@foreach ($shoppingList as $recipe)
    <div>
        <p>{{ $recipe->title }}</p>
        <div>
            <ul>
                @foreach ($recipe->ingredients as $ingredient)
                    <li>
                        <span>{!! $ingredient->title !!}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endforeach