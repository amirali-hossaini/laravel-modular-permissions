<?php

namespace App\Modules\Authentication\Http\Requests;

use Omalizadeh\ApiResponse\Requests\BaseApiRequest;

class LoginRequest extends BaseApiRequest
{
    protected $stopOnFirstFailure = true;

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
