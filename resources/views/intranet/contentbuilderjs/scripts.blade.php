<script src="{{asset('vendor/contentbuilder/contentbuilder/contentbuilder.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('vendor/contentbuilder/contentbuilder/saveimages.js')}}" type="text/javascript"></script>

<script type="text/javascript">
    var container = '.content-builder-container'; //clase del contenedor
    var urlGuardaImagenes = '{{route('intranet.contentbuilder.saveimage')}}';
    var mainLang = 'es';
    var currentLang = mainLang;
    var bodyJsonInput = $('#body_i18n');
    var bodyValues = '';
    var multilenguaje = false;
    var submitEnabled = true;
    var nextLang;
    var obj;

    function createContentbuilder() {
        return $.contentbuilder({
            container: container,
            snippetData: '{{asset('vendor/contentbuilder/assets/minimalist-blocks/snippetlist.html')}}',
            snippetPathReplace: ['assets/minimalist-blocks/', '{{url('/vendor/contentbuilder/assets/minimalist-blocks/')}}/'],
            iconselect: '{{asset('vendor/contentbuilder/assets/ionicons/icons.html')}}',
            cellFormat: '<div class="col-md-12"></div>',
            rowFormat: '<div class="row"></div>',
            framework: 'bootstrap'
        });
    }

    jQuery(document).ready(function ($) {
        if ($('#body_i18n').length) {
            //es multilenguaje

            var bodyValues = JSON.parse(bodyJsonInput.val());

            $('.form-edit-add').on('submit', function () {
                bodyJsonInput.val(JSON.stringify(bodyValues));
            });
            multilenguaje = true;
            submitEnabled = false;
        }

        obj = createContentbuilder(); //instancia el editor

        $('#btnViewSnippets').on('click', function () {
            obj.viewSnippets();
        });

        $('#btnViewHtml').on('click', function () {
            obj.viewHtml();
        });

        $('#enviar').on('click', function (e) {
            e.preventDefault(e);

            if (multilenguaje) {
                saveMultiLenguaje();
            }
            else {
                saveNormal();
            }
        });

        $('input[type=radio][name=i18n_selector]').change(function () {
            //$("html").fadeOut(1000);
            nextLang = $("input[name='i18n_selector']:checked").attr('id');
            console.log('Idioma clicado: ' + nextLang);
            $(container).data('saveimages').save();
        });

        $(container).saveimages({
            handler: urlGuardaImagenes, // handler for base64 image saving
            onComplete: onComplete
        });


        function onComplete() {
            if (!multilenguaje) { // modo normal
                var html = obj.html(); //Get content
                $('#body').val(html);
                $('.form-edit-add').submit();
            } else if (submitEnabled) { //multidioma al hacer submit
                console.log('guardar');
                bodyValues[currentLang] = obj.html();
                $('.form-edit-add').submit(); // hay un evento on submit solo para multilenguaje
            }
            else { //multidioma al cambiar pestaña
                bodyValues[currentLang] = obj.html();
                currentLang = nextLang;
                console.log('enviado');
                obj.loadHtml(bodyValues[nextLang]);
            }
        }

        function saveMultiLenguaje() {
            // Guarda las imagenes del idioma actual, porque las otras se guardaron al cambiar de un idioma a otro.

            //$("html").fadeOut(1000);
            submitEnabled = true;
            console.log('guardar?');

            $(container).data('saveimages').save();
        }

        function saveNormal() {
            $(container).data('saveimages').save();
            $("html").fadeOut(1000);//oculta la pagina mientras procesa
        }
    });
</script>
