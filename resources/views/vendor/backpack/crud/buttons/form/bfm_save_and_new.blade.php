@if (empty($id) || empty($entry))
<button type="submit" class="btn btn-primary ladda-button"
        data-style="zoom-in" data-route="{{ $crud->route . '/create' }}" id="js-save-and-new">
    <span class="ladda-label"><i class="fa fa-plus"></i> @lang('crud.buttons.save_and_new')</span>
</button>
@endif