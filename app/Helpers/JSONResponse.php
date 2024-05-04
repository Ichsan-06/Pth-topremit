<?php
namespace App\Helpers;


class JSONResponse {
    public static function send($data, $message, $status = 200) {
        $response = [
            'message' => $message,
            'data' => $data
        ];
        return response()->json($response, $status);
    }
}
