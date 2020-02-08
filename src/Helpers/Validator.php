<?php

namespace App\Helpers;

class Validator {

    /**
     * @param Array of $fields
     * @return bool
     */
    static function checkEmptyFields($fields) {
        foreach ($fields as $field) {
            if($field == null) {
                return true;
            }
        }
        return false;
    }

}