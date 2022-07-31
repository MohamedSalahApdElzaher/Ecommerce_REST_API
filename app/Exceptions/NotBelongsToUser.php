<?php

namespace App\Exceptions;

use Exception;

class NotBelongsToUser extends Exception
{
    public function render(){
        return [
            "error" => "The product not belngs to current user"
        ];
    }
}
