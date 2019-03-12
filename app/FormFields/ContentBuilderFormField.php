<?php
/**
 * Created by PhpStorm.
 * User: Javier
 * Date: 12/03/2019
 * Time: 7:18
 */

namespace App\FormFields;
use TCG\Voyager\FormFields\AbstractHandler;

class ContentBuilderFormField extends AbstractHandler
{
    protected $codename = 'contentbuilder';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('intranet.formfields.contentbuilder', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}