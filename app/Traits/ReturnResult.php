<?php

namespace App\Traits;

trait ReturnResult {

    public function returnJsonResult($status, $message, $statusCode = 200, array $extra = []) {
        return response()->json([
            'status' => $status,
            'message' => $message,
            ...$extra
        ], $statusCode);
    }

    public function errorMessage(string $message, array $extra = []) {
        return [
            'message' => $message,
            'status' => 'error',
            ...$extra
        ];
    }

    public function successMessage(string $message, array $extra = []) {
        return [
            'message' => $message,
            'status' => 'success',
            ...$extra
        ];
    }

    public function infoMessage(string $message, array $extra = []) {
        return [
            'message' => $message,
            'status' => 'info',
            ...$extra
        ];
    }

    public function warningMessage(string $message, array $extra = []) {
        return [
            'message' => $message,
            'status' => 'error',
            ...$extra
        ];
    }


}