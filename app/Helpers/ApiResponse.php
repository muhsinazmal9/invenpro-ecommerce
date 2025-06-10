<?php

use Illuminate\Validation\ValidationException;

function success($message = 'Success', $data = [], $statusCode = 200)
{
    return response()->json([
        'success' => true,
        'status' => $statusCode,
        'message' => $message,
        'data' => $data,
    ]);
}

function error($message = 'An error occurred', $statusCode = 500, $data = [])
{
    return response()->json([
        'success' => false,
        'status' => $statusCode,
        'message' => $message,
        'data' => $data,
    ]);
}

function notFound($message = 'Resource not found')
{
    return error($message, 404);
}

function forbidden($message = 'Forbidden')
{
    return error($message, 403);
}

function validationError(ValidationException $exception)
{
    $errors = $exception->errors();

    return response()->json([
        'success' => false,
        'status' => 403,
        'message' => 'Validation error',
        'errors' => $errors,
    ]);
}

function paginator($message, $model)
{

    $meta = [
        'current_page' => $model->currentPage(),
        'from' => $model->firstItem(),
        'last_page' => $model->lastPage(),
        'path' => $model->path(),
        'per_page' => $model->perPage(),
        'to' => $model->lastItem(),
        'total' => $model->total(),
    ];

    $data = [
        'data' => $model,
        'meta' => $meta,
    ];

    return success($message, $data);

}
