<form action="#" id="{{ str_random() }}" method="post" class="cms-box template"
      data-collapsed="{{ isset($template->id) ? 1 : 0 }}"
      novalidate>
    <div class="cms-box-header">
        <h3 class="cms-box-title">
            <i class="fa fa-arrows sortable-area"></i>
            {{ isset($template->name) ? $template->name : $template->getName() }}
        </h3>
        <div class="cms-box-tools pull-right">
            <button data-action="collapse-template" type="button" class="btn">
                @if (isset($template->id))
                    <i class="fa fa-chevron-left"></i>
                @else
                    <i class="fa fa-chevron-down"></i>
                @endif
            </button>
            <button data-action="remove" type="button" class="btn"><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
    <div class="cms-box-body" @if(isset($template->id)) style="display: none;" @endif>
        <input type="hidden" name="templateId" value="{{ isset($template->id) ? $template->id : 0 }}">
        <input type="hidden" name="templateType" value="{{ get_class($template) }}">
        {!! $template->getForm() !!}
    </div>
</form>