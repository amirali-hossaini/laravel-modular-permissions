<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SystemException extends Exception
{
    protected ?array $errors = null;

    public function __construct(
        string $message,
        int $code = Response::HTTP_UNPROCESSABLE_ENTITY,
        ?array $errors = null,
    ) {
        parent::__construct($message, $code);

        $this->errors = $errors;
    }

    public function render(): JsonResponse
    {
        return apiResponse()->errors($this->errors, $this->getCode())->message($this->getMessage())->get();
    }
}
