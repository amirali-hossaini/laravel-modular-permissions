<?php

namespace App\Modules\User\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserThumbResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
