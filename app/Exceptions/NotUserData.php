<?php

namespace App\Exceptions;

use Exception;

class NotUserData extends Exception
{
    public function render()
    {
        $response = [
            'success' => false,
            'message' => 'Data does not belongs to you'
        ];

        return response()->json($response, 401);
    }
}
