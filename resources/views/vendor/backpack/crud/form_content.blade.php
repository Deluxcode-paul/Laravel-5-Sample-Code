@backpackAssets('crud/form_content.js')

<form role="form">
    @if ($errors->any())
        <div class="col-md-12">
            <div class="callout callout-danger">
                <h4>{{ trans('backpack::crud.please_fix') }}</h4>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @foreach ($fields as $field)
        @if (view()->exists('vendor.backpack.crud.fields.'.$field['type']))
            @include('vendor.backpack.crud.fields.'.$field['type'], array('field' => $field))
        @else
            @include('crud::fields.'.$field['type'], array('field' => $field))
        @endif
    @endforeach
</form>
