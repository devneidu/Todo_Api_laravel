<?php

namespace App\Libraries;

use App\Exceptions\NotUserData;

class UserDataValidation {

    public static function BelongsToUser($id)
    {
        if($id != auth()->user()->id) {
            throw new NotUserData();
        }
    }
}