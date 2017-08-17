<?php
namespace App\Http\Validation\Classes;

use Illuminate\Validation\Validator as IlluminateValidator;

class CustomValidatorExtended extends IlluminateValidator {

    private $_default_messages = [
        "alpha_dash_spaces" => "The :attribute may only contain letters, spaces, and dashes.",
        "alpha_num_spaces" => "The :attribute may only contain letters, numbers, and spaces.",
        "url" => "The :attribute must be a Valid URL",
    ];

    public function __construct( $translator, $data, $rules, $messages = array(), $customAttributes = array() ) {
        parent::__construct( $translator, $data, $rules, $messages, $customAttributes );
        $this->setCustomStuff($messages);
    }

    /**
     * Setup any customizations etc
     *
     * @return void
     */
    protected function setCustomStuff($messages) {
        //setup our custom error messages
        $merged = collect($this->_default_messages)->merge($messages);
        $this->setCustomMessages( $merged->all() );
    }

    /**
     * Allow only alphabets, spaces and dashes (hyphens and underscores)
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateAlphaDashSpaces( $attribute, $value ) {
        return (bool) preg_match( "/^[A-Za-z\s-_]+$/", $value );
    }

    /**
     * Allow only alphabets, numbers, and spaces
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateAlphaNumSpaces( $attribute, $value ) {
        return (bool) preg_match( "/^[A-Za-z0-9\s]+$/", $value );
    }

    /**
     * Allow only Valid Url
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateUrl( $attribute, $value ) {
        return (bool) preg_match("/(?:http|https)?(?:\:\/\/)?(?:www.)?(([A-Za-z0-9-]+\.)*[A-Za-z0-9-]+\.[A-Za-z]+)(?:\/.*)?/im", $value );
    }

    /**
     * Validate string with comma delimited
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateCommaDelimited( $attribute, $value ) {
        $value = str_replace('　', ' ', $value);
        $array = explode(",", $value);
        foreach ($array as $k => $v) {
            $v = trim($v);
            if (empty($v))
                return false;
        }
        return true;
    }
}
