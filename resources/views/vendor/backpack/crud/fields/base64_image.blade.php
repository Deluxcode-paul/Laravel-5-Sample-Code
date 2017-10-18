@backpackAssets('cropper')
@backpackAssets('crud/fields/base64_image.css')
@backpackAssets('crud/fields/base64_image.js')

<div class="form-group image" data-preview="#{{ $field['name'] }}" data-aspectRatio="{{ $field['aspect_ratio'] }}"
     data-crop="{{ $field['crop'] }}">
    <div>
        <label>{!! $field['label'] !!}</label>
    </div>
    <div class="row">
        <div class="col-sm-6" style="margin-bottom: 20px;">
            <img id="mainImage"
                 src="{{ isset($field['src']) ? $entry->where('id', $entry->id)->first()->{$field['src']}() : $field['value'] }}">
        </div>
        @if ($field['crop'])
            <div class="col-sm-3">
                <div class="docs-preview clearfix">
                    <div id="{{ $field['name'] }}" class="img-preview preview-lg">
                        <img src=""
                             style="display: block; min-width: 0px !important; min-height: 0px !important; max-width: none !important; max-height: none !important; margin-left: -32.875px; margin-top: -18.4922px; transform: none;">
                    </div>
                </div>
            </div>
        @endif
        <input type="hidden" id="hiddenFilename" name="{{ $field['filename'] }}" value="">
    </div>
    <div class="btn-group">
        <label class="btn btn-primary btn-file">
            Upload <input type="file" accept="image/*" id="uploadImage" class="hide">
            <input type="hidden" id="hiddenImage" name="{{ $field['name'] }}">
        </label>
        @if ($field['crop'])
            <button class="btn btn-default" id="rotateLeft" type="button" style="display: none;">Rotate Left</button>
            <button class="btn btn-default" id="rotateRight" type="button" style="display: none;">Rotate Right</button>
            <button class="btn btn-default" id="zoomIn" type="button" style="display: none;">Zoom In</button>
            <button class="btn btn-default" id="zoomOut" type="button" style="display: none;">Zoom Out</button>
            <button class="btn btn-warning" id="reset" type="button" style="display: none;">Reset</button>
        @endif
        <button class="btn btn-danger" id="remove" type="button">Remove</button>
    </div>
</div>
