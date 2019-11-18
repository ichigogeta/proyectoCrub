<?php

namespace App\Providers;

use App\FormFields\ContentBuilderFormField;
use App\Http\Controllers\Admin\VoyagerController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

        ## Validador personalizado para imágenes
        Validator::extend('image_validator', function ($message, $attribute, $rule, $parameters) {

            return false;

            // return new ImageValidator
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\TCG\Voyager\Http\Controllers\VoyagerController::class, VoyagerController::class);
        Voyager::addFormField(ContentBuilderFormField::class);
    }
}
