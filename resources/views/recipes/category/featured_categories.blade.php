@if ($featuredCategories->count())
    <section class="section-featured">
        <ul class="list-category-circles">
            @foreach($featuredCategories as $category)
                <li>
                    <a href="{{ $category->getSubCategoryUrl() }}">
                        <span class="img">
                            <img src="{{ $category->getImage('recipe_category_recipes_featured') }}" alt="{{ $category->title }}" />
                        </span>
                        <span class="title">{{ $category->title }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </section>
@endif