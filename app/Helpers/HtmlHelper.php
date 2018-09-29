<?php
/**
 * Created by PhpStorm.
 * User: Javier Garcia
 * Date: 22/08/2017
 * Time: 15:47
 */

class jsHelper
{
    /**
     * Shortcut que confirma por JS si quieres borrar o no.
     *
     * @return string
     */
    public static function confirm()
    {
        return 'return ConfirmDelete(&quot;¿Estas seguro de que desea eliminar?&quot;);';
    }

}

class HtmlHelper
{
    /**
     * Shorcut HTML, confirma si eliminas y luego ejecuta la ruta especificada.
     *
     * @param $actionRoute
     * @return string
     */
    public static function deleteButton($actionRoute)
    {
        return '<form action="' . $actionRoute . '" method="POST">' .
            csrf_field() . method_field('DELETE') .
            '<button type = "submit" class="btn btn-danger delete" onclick="' . jsHelper::confirm() . ' " >Borrar</button></form >';
    }

    /**
     * Imprime 'selected' si los dos valores son iguales.
     *
     * @param $a
     * @param $b
     * @return string
     */
    public static function selected($a, $b)
    {
        if ($a == $b)
            return 'selected';
        return '';
    }

    /**
     * Crea url con slug para las noticias/blog
     *
     * @param \App\Post $post
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public static function postURL($post)
    {
        return url('noticias/' . $post->id . '/' . $post->slug);
    }

    /**
     * Imprime el <script> que invoca tinyMCE sobre la textarea que indiques.
     *
     * @param string $elem referencia al elemento, ej #mitexto
     * @return string
     */
    public static function tinyMCE($elem)
    {
        return "<script src='" . url('js/tinymce/tinymce.min.js') . "'></script>\n" .
            "  <script>\n" .
            "  tinymce.init({\n" .
            "    selector: '" . $elem . "'\n" .
            "  });\n" .
            "</script>";
    }

}
