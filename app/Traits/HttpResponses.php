<?php

namespace App\Traits;

trait HttpResponses
{
    protected function success($data = [], $message = null, $code = 200, $additional_data = [])
    {
        return response()->json([
            'status' => 'Request was successful.',
            'message' => $message,
            'data' => $data,
            'additonal_data' => $additional_data,
        ], $code);
    }

    protected function error($message = 'Error has ocurred', $code)
    {
        return response()->json([
            'status' => 'Failed.',
            'message' => $message,
        ], $code);
    }
}
