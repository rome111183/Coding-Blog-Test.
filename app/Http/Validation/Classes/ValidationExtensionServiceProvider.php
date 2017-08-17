<?php
namespace App\Http\Validation\Classes;

use Illuminate\Support\ServiceProvider;

class ValidationExtensionServiceProvider extends ServiceProvider {

    public function register() {}

    public function boot() {
        $this->app->validator->resolver( function( $translator, $data, $rules, $messages = array(), $customAttributes = array() ) {
            return new CustomValidatorExtended( $translator, $data, $rules, $messages, $customAttributes );
        } );
    }
} //end of class