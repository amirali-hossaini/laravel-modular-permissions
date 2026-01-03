<?php

namespace App\Modules\User\Http\Requests;

use App\Modules\AccessControl\Models\OrganizationalChart;
use App\Modules\AccessControl\Models\Permission;
use App\Modules\AccessControl\Models\Role;
use App\Modules\User\Models\User;
use Illuminate\Validation\Rule;
use Omalizadeh\ApiResponse\Requests\BaseApiRequest;

class UpdateUserRequest extends BaseApiRequest
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
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique(User::class, 'email')->ignore($this->user->id),
                'max:255',
            ],
            'password' => [
                'sometimes',
                'string',
                'min:8',
                'max:255',
            ],
            'permission_ids' => [
                'array',
                'required_without_all:role_ids,organizational_chart_ids',
            ],
            'permission_ids.*' => [
                'integer',
                Rule::exists(Permission::class, 'id'),
            ],
            'role_ids' => [
                'array',
                'required_without_all:permission_ids,organizational_chart_ids',
            ],
            'role_ids.*' => [
                'integer',
                Rule::exists(Role::class, 'id'),
            ],
            'organizational_chart_ids' => [
                'array',
                'required_without_all:permission_ids,role_ids',
            ],
            'organizational_chart_ids.*' => [
                'integer',
                Rule::exists(OrganizationalChart::class, 'id'),
            ],
        ];
    }
}
