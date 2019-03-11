<script src="{{asset('vendor/contentbuilder/contentbuilder/contentbuilder.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('vendor/contentbuilder/contentbuilder/saveimages.js')}}" type="text/javascript"></script>

<script type="text/javascript">

    jQuery(document).ready(function ($) {

        var obj = $.contentbuilder({
            container: '.content-builder-container',
            snippetData: '{{asset('vendor/contentbuilder/assets/minimalist-blocks/snippetlist.html')}}',
            snippetPathReplace: ['assets/minimalist-blocks/', '{{url('/vendor/contentbuilder/assets/minimalist-blocks/')}}/'],
            iconselect: '{{asset('vendor/contentbuilder/assets/ionicons/icons.html')}}',
            cellFormat: '<div class="col-md-12"></div>',
            rowFormat: '<div class="row"></div>',
            framework: 'bootstrap'
        });

        $('#btnViewSnippets').on('click', function () {
            obj.viewSnippets();
        });

        $('#btnViewHtml').on('click', function () {
            obj.viewHtml();
        });
        /*
        $('#btnSave').on('click', function () {
            save(obj);
        });
        */
        $('#enviar').on('click', function (e) {
            e.preventDefault(e);

            if ($('body_i18n').length) {
                //modo multilenguaje
            }
            else {
                save(obj, e);
            }
        });

        $('input[type=radio][name=i18n_selector]').change(function () {
            alert(this.id);

        });

    });

    function save(obj, e) {
        $(".content-builder-container").saveimages({
            handler: '{{route('intranet.contentbuilder.saveimage')}}', // handler for base64 image saving
            onComplete: function () {
                //alert('completado')
                var html = obj.html(); //Get content
                $('#body').val(html);
                //alert('enviar');
                $('.form-edit-add').submit();
            }
        });
        $(".content-builder-container").data('saveimages').save();
        $("html").fadeOut(1000);//oculta la pagina mientras procesa
    }

</script>