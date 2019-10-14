<?php

namespace App\Exception;

class InvalidInputParamException extends ValidateException {
    public function __construct( string $param = "" ) {
        parent::__construct( $param.' is empty', 400 );
    }
}