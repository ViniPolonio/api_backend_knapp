<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($data = [], $message = 'Operação realizada com sucesso.', $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public static function error($message = 'Erro na operação.', $error = null, $status = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error
        ], $status);
    }
}
