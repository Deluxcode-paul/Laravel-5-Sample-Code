@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">{{ trans('backpack::base.administration') }}</li>
                @can('recipes-access')
                    <li>
                        <a href="{{ url('admin/recipes') }}">
                            <i class="fa fa-file-text-o"></i> <span>{{ trans('crud.labels.recipes') }}</span>
                        </a>
                    </li>
                @endcan
                @can('admin-full-access')
                    <li>
                        <a href="{{ url('admin/recipe-categories') }}">
                            <i class="fa fa-th"></i> <span>{{ trans('crud.labels.recipe_categories') }}</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-filter"></i>
                            <span>{{ trans('crud.labels.recipe_filters') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
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
                    <li>
                        <a href="{{ url('admin/ingredients') }}">
                            <i class="fa fa-flask"></i> <span>{{ trans('crud.labels.ingredients') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/tags') }}">
                            <i class="fa fa-tags"></i> <span>{{ trans('crud.labels.tags') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/call-to-actions') }}">
                            <i class="fa fa-hand-pointer-o"></i> <span>{{ trans('crud.labels.call_to_actions') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/users') }}">
                            <i class="fa fa-user"></i> <span>{{ trans('crud.labels.users') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/top-chefs') }}">
                            <i class="fa fa-user"></i> <span>{{ trans('crud.labels.top_chefs') }}</span>
                        </a>
                    </li>
                @endcan
                <li class="header">{{ trans('backpack::base.user') }}</li>
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
