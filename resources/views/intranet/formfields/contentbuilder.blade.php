<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title"></h3>
        <div class="panel-actions">
            @include('intranet.contentbuilderjs.botones')
            <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen"
               aria-hidden="true"></a>
        </div>
    </div>

    <div class="panel-body">
        <div class="content-builder-container">
            @if(isset($dataTypeContent->{$row->field})){!!old($row->field, $dataTypeContent->{$row->field}) !!}@else{!!old($row->field)!!}
            @endif</div>
        <input type="hidden" id="body" name="body"/>
    </div>
</div><!-- .panel -->