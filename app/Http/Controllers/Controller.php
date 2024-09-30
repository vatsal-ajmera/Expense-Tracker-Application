<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function send_response($data, $message, $status_code = 200)
    {
        return response()->json(
            [
                'status' => TRUE,
                'data' => $data,
                'message' => $message,
            ],
            $status_code
        );
    }

    protected function send_error_response($data, $err_message, $status_code, $payload = [])
    {
        return response()->json(
            [
                'status' => FALSE,
                'payload' => $payload,
                'message' => $err_message,
                'data' => $data
            ],
            $status_code ?? 400
        );
    }
}
