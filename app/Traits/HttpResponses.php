<?php

namespace App\Traits;

trait HttpResponses
{
    protected function success($data = null, $code = 200)
    {
        return response()->json([
            'success' => true,
            'time' => now()->toTimeString(),
            'data' => $data
        ], $code);
    }

    protected function error($data = null, $code)
    {
        return response()->json([
            'success' => false,
            'time' => now()->toTimeString(),
            'data' => $data
        ], $code);
    }
}
