<?php
/**
 * Created by PhpStorm.
 * User: Javier
 * Date: 01/04/2019
 * Time: 18:27
 */

namespace App\FormFields;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Models\DataType;

class Lector
{
    /*
     * Clase destinada a manejar los inputs de Voyager, útil para personalizar una vista edit-add rápido
     */

    public $dataType;
    public $dataTypeRows;
    public $dataTypeContent;

    public function __construct($dataType, $dataTypeContent)
    {
        $this->dataTypeContent = $dataTypeContent;
        $this->dataType = $dataType;
        $this->dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows')};
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->dataTypeContent;
    }

    /**
     * Comprueba si estamos en modo edición
     * @return bool
     */
    public function isEdit()
    {
        if (is_null($this->dataTypeContent->getKey()))
            return false;
        else
            return true;
    }

    /**
     * Genera bloque DIV de voyager a partir del nombre de la columna
     * @param $fieldName
     * @return string
     */
    public function formField($fieldName)
    {
        $row = $this->findRow($fieldName);
        if (!$row)
            (dd($fieldName)); //te avisa de que campo llamas pero no existe

        return $this->formFieldFromRow($row);
    }

    /**
     * Genera bloque DIV de voyager a partir un objeto $row
     * @param $row
     * @return string
     */
    public function formFieldFromRow($row)
    {
        $display_options = isset($row->details->display) ? $row->details->display : NULL;

        return '<div class="form-group ' . ($row->type == 'hidden' ? 'hidden' : '') .
            ' col-md-' . (isset($display_options->width) ? $display_options->width : 12) . '" ' .
            ((isset($display_options->id)) ? "id=$display_options->id" : '') . ' >' .
            $row->slugify .
            '<label for="name">' . $row->display_name . '</label>' .
            $this->formInputFromRow($row) .
            '</div>';
    }

    /**
     * Genera input de Voyager a partir e una variable $row
     * @param $fieldName
     * @return string
     */
    public function formInput($fieldName)
    {
        $row = $this->findRow($fieldName);
        if (!$row)
            (dd($fieldName)); //te avisa de que campo llamas pero no existe

        return $this->formInputFromRow($row);
    }

    /**
     * Genera input de Voyager a partir e una variable $row
     * @param $row
     * @return string
     */
    public function formInputFromRow($row)
    {
        if ($row->type == 'relationship') {
            $input = $this->relationship($row);
        } else {
            $input = app('voyager')->formField($row, $this->dataType, $this->dataTypeContent);
        }

        $afterForm = '';
        foreach (app('voyager')->afterFormFields($row, $this->dataType, $this->dataTypeContent) as $after) {
            $afterForm .= $after->handle($row, $this->dataType, $this->dataTypeContent);
        }

        return $input . PHP_EOL . $afterForm;
    }

    /**
     * @param $fieldName
     * @return DataType
     */
    public function findRow($fieldName)
    {
        return $this->dataTypeRows->where('field', $fieldName)->first();
    }

    private function relationship($row)
    {
        return view('voyager::formfields.relationship',
            [
                'options' => $row->details,
                'row' => $row, 'dataType' => $this->dataType,
                'dataTypeContent' => $this->dataTypeContent
            ]);

    }


}