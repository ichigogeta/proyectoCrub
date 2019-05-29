<?php

if (!function_exists('public_storage_path')) {
    /**
     * @param $path
     * @return string
     */
    function public_storage_path($path = null)
    {
        return storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $path);
    }
}

if (!function_exists('model_from_slug')) {
    /**
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    function model_from_slug($slug)
    {
        $dataType = \TCG\Voyager\Facades\Voyager::model('DataType')->where('slug', '=', $slug)->first();
        if (!$dataType)
            return $dataType;

        $model = app($dataType->model_name);
        return $model;
    }
}

