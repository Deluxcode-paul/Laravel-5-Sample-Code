@if ($crud->hasAccess('delete'))
<a href="{{ url($crud->route.'/'.$entry->getKey()) }}"
   class="btn btn-xs btn-default"
   data-button-type="delete"
   data-button-alert="{{ trans('crud.alerts.delete_page') }}"
   title="{{ trans('backpack::crud.delete') }}"
>
    <i class="fa fa-remove"></i>
</a>
@endif