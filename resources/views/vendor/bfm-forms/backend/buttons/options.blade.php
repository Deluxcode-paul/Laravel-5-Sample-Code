@if(in_array($field->type, config('bfm-forms.fieldTypesWithOptions')))
    <a href="{{ route('crud.forms/{fieldId}/options.index', ['fieldId' => $field->id]) }}" class="btn btn-xs btn-default">
        <i class="fa fa-bars"></i> @lang('bfm-forms::main.links.options') <span class="badge">{{ $field->options->count() }}</span>
    </a>
@endif
