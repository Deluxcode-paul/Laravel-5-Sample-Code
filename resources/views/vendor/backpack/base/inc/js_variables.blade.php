<script type='text/javascript'>
    var backpack = {
        ckeditorBrowseUrl: '{{ url('admin/elfinder/ckeditor') }}',
        tinymceBrowseUrl: '{{ url('admin/elfinder/tinymce4') }}',
        ajax: {
            IngredientGroupsUrl: '{{ route('backend.ajax.ingredient_groups') }}',
            TagsUrl: '{{ route('backend.ajax.tags') }}'
        },
        elfinder: {
            prefixUrl: '{{ url(config('elfinder.route.prefix')) }}',
            connectorUrl: '{{ route('elfinder.connector') }}'
        },
        @unless (empty($crud))
        crud: {
            pageLength: parseInt({{ $crud->getDefaultPageLength() }}),
            detailsRow: false,
            ajaxTable: false,
            ajaxUrl: '{{ url($crud->route . '/search') }}',
            sortable: {
                maxLevels: parseInt({{ $crud->reorder_max_level or 3 }})
            }
        },
        @endunless
        requestUrl: '{{ Request::url() }}',
        lang: {
            emptyTable: '{{ trans('backpack::crud.emptyTable') }}',
            info: '{{ trans('backpack::crud.info') }}',
            infoEmpty: '{{ trans('backpack::crud.infoEmpty') }}',
            infoFiltered: '{{ trans('backpack::crud.infoFiltered') }}',
            infoPostFix: '{{ trans('backpack::crud.infoPostFix') }}',
            thousands: '{{ trans('backpack::crud.thousands') }}',
            lengthMenu: '{{ trans('backpack::crud.lengthMenu') }}',
            loadingRecords: '{{ trans('backpack::crud.loadingRecords') }}',
            processing: '{{ trans('backpack::crud.processing') }}',
            search: '{{ trans('backpack::crud.search') }}',
            zeroRecords: '{{ trans('backpack::crud.zeroRecords') }}',
            paginate: {
                first: '{{ trans('backpack::crud.paginate.first') }}',
                last: '{{ trans('backpack::crud.paginate.last') }}',
                next: '{{ trans('backpack::crud.paginate.next') }}',
                previous: '{{ trans('backpack::crud.paginate.previous') }}'
            },
            aria: {
                sortAscending: '{{ trans('backpack::crud.aria.sortAscending') }}',
                sortDescending: '{{ trans('backpack::crud.aria.sortDescending') }}'
            },
            notification: {
                deleteConfirm: '{{ trans('backpack::crud.delete_confirm') }}',
                deleteSuccess: {
                    title: '{{ trans('backpack::crud.delete_confirmation_title') }}',
                    message: '{{ trans('backpack::crud.delete_confirmation_message') }}',
                },
                deleteError: {
                    title: '{{ trans('backpack::crud.delete_confirmation_not_title') }}',
                    message: '{{ trans('backpack::crud.delete_confirmation_not_message') }}'
                },
                deleteCancel: {
                    title: '{{ trans('backpack::crud.delete_confirmation_not_deleted_title') }}',
                    message: '{{ trans('backpack::crud.delete_confirmation_not_deleted_message') }}'
                },
                reorderSuccess: {
                    title: '{{ trans('backpack::crud.reorder_success_title') }}',
                    message: '{{ trans('backpack::crud.reorder_success_message') }}'
                },
                reorderError: {
                    title: '{{ trans('backpack::crud.reorder_error_title') }}',
                    message: '{{ trans('backpack::crud.reorder_error_message') }}'
                }
            },
            errors: {
                detailsRowLoading: '{{ trans('backpack::crud.details_row_loading_error') }}'
            }
        }
    };

    var current_url = '{{ url(Route::current()->getUri()) }}';
    var csrf_token = '{{ csrf_token() }}';

    @unless (empty($crud))
        @if ($crud->details_row)
            backpack.crud.detailsRow = true;
        @endif

        @if ($crud->ajaxTable())
            backpack.crud.ajaxTable = true;
        @endif
    @endunless
</script>