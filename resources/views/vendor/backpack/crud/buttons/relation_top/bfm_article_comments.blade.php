@if (url($crud->route) == url('admin/articles/'.$articleId.'/comments'))
    <span class="btn btn-sm btn-default btn-primary active">
        <i class="fa fa-comment"></i> {{ trans('crud.buttons.comments') }}
    </span>
@else
    <a href="{{ url('admin/articles/'.$articleId.'/comments') }}" class="btn btn-sm btn-default @if('crud.article-comments/{owner}/replies.index' == Route::getCurrentRoute()->getName()) btn-primary active @endif">
        <i class="fa fa-comment"></i> {{ trans('crud.buttons.comments') }}
    </a>
@endif