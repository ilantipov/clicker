<?php


namespace App\Http\Controllers\Api;


trait jsonResponse
{

    private $response = [
        'status_ok' => false,
        'status_message' => ''
    ];

    private function throwJsonError(string $errorText, string $redirect_to = '')
    {
        $this->response = [
            'status_ok' => false,
            'error_text' => $errorText,
            'redirect_to' => $redirect_to
        ];

        response()->json($this->response, 200)->send();
        die();
    }

    private function send_ok(string $message = '', string $redirect_to = '')
    {

        $this->response = [
            'status_ok' => true,
            'status_message' => $message,
            'redirect_to' => $redirect_to
        ];

        return response()->json($this->response, 200)->send();
    }
}
