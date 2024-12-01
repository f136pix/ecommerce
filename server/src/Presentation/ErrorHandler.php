<?php

use GraphQL\Error\Error;
use App\Application\Exceptions\PublicException;

function customErrorFormatter(Error $error): array
{
    if ($error->getPrevious() instanceof PublicException) {
        return [
            'message' => $error->getPrevious()->getMessage(),
            'extensions' => [
                'category' => 'public',
                'custom' => 'This is a public error message'
            ],
        ];
    }

    return [
        'message' => "There was a internal error, please try again later",
        'extensions' => [
            'category' => 'internal',
            'custom' => 'This is an internal error message'
        ],
    ];
}

function customErrorHandler(array $errors, callable $formatter): array
{
    foreach ($errors as $error) {
        error_log($error->getMessage());
    }
    return array_map($formatter, $errors);
}