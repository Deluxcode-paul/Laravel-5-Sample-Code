@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                @can('admin-full-access')
                <li class="header">{{ trans('backpack::base.administration') }}</li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-text-o"></i>
                            <span>{{ trans('crud.labels.recipes') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ url('admin/recipes') }}">
                                    <i class="fa fa-file-text-o"></i> <span>{{ trans('crud.labels.recipes') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/recipe-categories') }}">
                                    <i class="fa fa-th"></i> <span>{{ trans('crud.labels.recipe_categories') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/ingredients') }}">
                                    <i class="fa fa-flask"></i> <span>{{ trans('crud.labels.ingredients') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/allergens') }}">
                                    <i class="fa fa-list"></i> <span>{{ trans('crud.labels.allergens') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/blessing-types') }}">
                                    <i class="fa fa-list"></i> <span>{{ trans('crud.labels.blessing_types') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/cuisines') }}">
                                    <i class="fa fa-list"></i> <span>{{ trans('crud.labels.cuisines') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/diets') }}">
                                    <i class="fa fa-list"></i> <span>{{ trans('crud.labels.diets') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/holidays') }}">
                                    <i class="fa fa-list"></i> <span>{{ trans('crud.labels.holidays') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/sources') }}">
                                    <i class="fa fa-list"></i> <span>{{ trans('crud.labels.sources') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-image-o"></i>
                            <span>{{ trans('crud.labels.lifestyle') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ url('admin/articles') }}">
                                    <i class="fa fa-file-image-o"></i> <span>{{ trans('crud.labels.articles') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/article-categories') }}">
                                    <i class="fa fa-th"></i> <span>{{ trans('crud.labels.article_categories') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-film"></i>
                            <span>{{ trans('crud.labels.watch') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ url('admin/videos') }}">
                                    <i class="fa fa-youtube-play"></i> <span>{{ trans('crud.labels.all_videos') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/shows') }}">
                                    <i class="fa fa-film"></i> <span>{{ trans('crud.labels.shows') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-comments-o"></i>
                            <span>{{ trans('crud.labels.community') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ url('admin/community-questions') }}">
                                    <i class="fa fa-question"></i> <span>{{ trans('crud.labels.general_questions') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('admin/tags') }}">
                            <i class="fa fa-tags"></i> <span>{{ trans('crud.labels.tags') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/cms') }}">
                            <i class="fa fa-newspaper-o"></i> <span>{{ trans('crud.labels.cms_pages') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/call-to-actions') }}">
                            <i class="fa fa-hand-pointer-o"></i> <span>{{ trans('crud.labels.call_to_actions') }}</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="{{ url('/admin/contact-submissions') }}">
                            <i class="fa fa-bullhorn"></i>
                            <span>{{ trans('crud.labels.contact_submissions') }}</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="{{ url('/admin/subscribers') }}">
                            <i class="fa fa-envelope"></i>
                            <span>{{ trans('crud.labels.newsletter_subscribers') }}</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span>{{ trans('crud.labels.users') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ url('admin/users') }}">
                                    <i class="fa fa-user"></i> <span>{{ trans('crud.labels.all_users') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/top-chefs') }}">
                                    <i class="fa fa-user"></i> <span>{{ trans('crud.labels.top_chefs') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-cogs"></i>
                            <span>{{ trans('crud.labels.system') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ route('backend.system.flush-cache') }}">
                                    <i class="fa fa-recycle"></i> <span>{{ trans('crud.labels.flush_cache') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('backend.system.flush-thumbnails') }}">
                                    <i class="fa fa-recycle"></i> <span>{{ trans('crud.labels.flush_thumbs') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                <li class="header">{{ trans('backpack::base.user') }}</li>
                @can('articles-access')
                    @cannot('admin-full-access')
                        <li>
                            <a href="{{ url('admin/articles') }}">
                                <i class="fa fa-file-image-o"></i> <span>{{ trans('crud.labels.my_articles') }}</span>
                            </a>
                        </li>
                    @endcannot
                @endcan
                @can('recipes-access')
                    @cannot('admin-full-access')
                        <li>
                            <a href="{{ url('admin/recipes') }}">
                                <i class="fa fa-file-text-o"></i> <span>{{ trans('crud.labels.my_recipes') }}</span>
                            </a>
                        </li>
                    @endcannot
                @endcan
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-commenting"></i>
                        <span>{{ trans('crud.labels.my_activity') }}</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('recipes-access')
                            <li>
                                <a href="{{ url('admin/my-reviews') }}">
                                    <i class="fa fa-star-half-o"></i> <span>{{ trans('crud.labels.my_recipe_reviews') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/my-review-comments') }}">
                                    <i class="fa fa-comments"></i> <span>{{ trans('crud.labels.my_review_comments') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/my-recipe-questions') }}">
                                    <i class="fa fa-question"></i> <span>{{ trans('crud.labels.my_recipe_questions') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/my-recipe-answers') }}">
                                    <i class="fa fa-comment"></i> <span>{{ trans('crud.labels.my_recipe_answers') }}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                <li>
                    <a href="{{ url('admin/logout') }}">
                        <i class="fa fa-sign-out"></i>
                        <span>{{ trans('backpack::base.logout') }}</span>
                    </a>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
@endif
