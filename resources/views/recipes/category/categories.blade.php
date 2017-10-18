<section class="section-categories">
    <div class="spacer">
        @if ($commonCategories->count())
            <ul class="list-category">
                @foreach($commonCategories as $category)
                    <li>
                        <a href="{{ $category->getSubCategoryUrl() }}" title="{{ $category->title }}">
                            <img src="{{ $category->getImage('recipe_category_recipes_common') }}" alt="{{ $category->title }}" />
                            <span>{{ $category->title }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</section>