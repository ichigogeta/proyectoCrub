@extends('vendor.voyager.custom_views_extend.browse')

{{-- Botones Personalizados en la parte superior --}}
@section('buttons_custom_top')

@endsection

{{-- Antes de los botones por cada fila --}}
@section('row_buttons_pre_actions')
    {{--investigar como obtener $data--}}
@endsection

{{-- Después de los botones por cada fila --}}
@section('row_buttons_post_actions')
    {{--investigar como obtener $data--}}
@endsection

@section('javascript')
    @parent
    <script>
        $(document).ready(() => {
            function btnAction(ele, route) {
                var dataId = $(ele).closest('#bread-actions').attr('data-id');
                window.location.href =  route + '/' + dataId;
            }

            /**
             * Añade el enlace al elemento a partir del atributo "data-route"
             */
            function linkAction(ele) {
                var dataId = $(ele).closest('#bread-actions').attr('data-id');
                var route = $(ele).attr('data-route');
                $(ele).attr('href', route + '/' + dataId);
            }

            /**
             * Recorre todos los elementos con la clase "linkAction" y que
             * tengan el atributo "data-route" con la ruta de la acción para
             * añadir detrás el id.
             */
            $.each($('.linkAction'), (idx, ele) => {
                linkAction(ele);
            });
        });
    </script>
@endsection
