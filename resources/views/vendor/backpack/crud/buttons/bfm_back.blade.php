<a href="{{ (URL::current() == url()->previous()) ? url($crud->route) : url()->previous() }}">
    <i class="fa fa-angle-double-left"></i> @lang('crud.buttons.back')
</a><br><br>