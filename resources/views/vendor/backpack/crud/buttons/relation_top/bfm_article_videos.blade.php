@if (url($crud->route) == url('admin/articles/'.$articleId.'/videos'))
    <span class="btn btn-sm btn-default btn-primary active">
        <i class="fa fa-youtube-play"></i> {{ trans('crud.buttons.videos') }}
    </span>
@else
    <a href="{{ url('admin/articles/'.$articleId.'/videos') }}" class="btn btn-sm btn-default">
        <i class="fa fa-youtube-play"></i> {{ trans('crud.buttons.videos') }}
    </a>
@endif