@extends('backpack::layout')

@adminlteAssets('jqueryUI')
@backpackAssets('nestedSortable')
@backpackAssets('crud/reorder.js')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
            <small>{{ trans('backpack::crud.all') }} <span
                        class="text-lowercase">{{ $crud->entity_name_plural }}</span> {{ trans('backpack::crud.in_the_database') }}.
            </small>
        </h1>
        @if (Breadcrumbs::exists('crud'))
            {!! Breadcrumbs::render('crud', empty($breadcrumbs) ? [] : $breadcrumbs) !!}
        @endif
    </section>
@endsection

@section('content')
    <?php
    function tree_element($entry, $key, $all_entries, $crud)
    {
        if (!isset($entry->tree_element_shown)) {
            // mark the element as shown
            $all_entries[$key]->tree_element_shown = true;
            $entry->tree_element_shown = true;
            // show the tree element
            echo '<li id="list_' . $entry->getKey() . '">';
            echo '<div><span class="disclose"><span></span></span>' . $entry->{$crud->reorder_label} . '</div>';
            // see if this element has any children
            $children = [];
            foreach ($all_entries as $key => $subentry) {
                if ($subentry->parent_id == $entry->getKey()) {
                    $children[] = $subentry;
                }
            }

            $children = collect($children)->sortBy('lft');
            if (count($children)) {
                echo '<ol>';
                foreach ($children as $key => $child) {
                    $children[$key] = tree_element($child, $child->getKey(), $all_entries, $crud);
                }
                echo '</ol>';
            }
            echo '</li>';
        }

        return $entry;
    }
    ?>
    <div>
        @if ($crud->hasAccess('list'))
            @include('vendor.backpack.crud.buttons.bfm_back')
        @endif

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('backpack::crud.reorder').' '.$crud->entity_name_plural }}</h3>
            </div>
            <div class="box-body">
                <p>{{ trans('backpack::crud.reorder_text') }}</p>
                <ol class="sortable">
                    <?php
                    $all_entries = collect($entries->all())->sortBy('lft')->keyBy($crud->getModel()->getKeyName());
                    $root_entries = $all_entries->filter(function ($item) {
                        return $item->parent_id == 0;
                    });
                    ?>
                    @foreach ($root_entries as $key => $entry)
                        <?php
                        $root_entries[$key] = tree_element($entry, $key, $all_entries, $crud);
                        ?>
                    @endforeach
                </ol>
                <button id="toArray" class="btn btn-success ladda-button" data-style="zoom-in"><span
                            class="ladda-label"><i class="fa fa-save"></i> {{ trans('backpack::crud.save') }}</span>
                </button>
            </div>
        </div>
    </div>
@endsection
