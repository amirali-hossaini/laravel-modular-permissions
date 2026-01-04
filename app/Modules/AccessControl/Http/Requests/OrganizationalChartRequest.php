<?php

namespace App\Modules\AccessControl\Http\Requests;

use App\Modules\AccessControl\Models\Permission;
use Illuminate\Validation\Rule;
use Omalizadeh\ApiResponse\Requests\BaseApiRequest;

class OrganizationalChartRequest extends BaseApiRequest
{
    protected $stopOnFirstFailure = true;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'permission_ids' => [
                'required',
                'array',
            ],
            'permission_ids.*' => [
                'integer',
                Rule::exists(Permission::class, 'id'),
            ],
        ];
    }
}
