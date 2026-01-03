<?php

namespace App\Modules\AccessControl\Exceptions;

use App\Exceptions\SystemException;
use Illuminate\Http\Response;

class PermissionDeniedException extends SystemException
{
    public function __construct(string $message = 'You don\'t have the required permission.', int $code = Response::HTTP_FORBIDDEN, ?array $errors = null)
    {
        parent::__construct($message, $code, $errors);
    }
}
