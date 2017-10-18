<a href="{{ route('crud.forms/{formId}/submits.index', ['formId' => $form->id]) }}"
   class="btn btn-xs btn-default m-r-5">
    <i class="fa fa-check-circle"></i> @lang('bfm-forms::main.crud_entities.submit.plural') <span class="badge">{{ $form->submits->count() }}</span>
</a>
