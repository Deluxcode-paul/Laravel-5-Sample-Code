<a href="{{ route('crud.forms/{formId}/fields.index', ['formId' => $form->id]) }}"
   class="btn btn-xs btn-default">
    <i class="fa fa-bars"></i> @lang('bfm-forms::main.links.fields') <span class="badge">{{ $form->fields->count() }}</span>
</a>
