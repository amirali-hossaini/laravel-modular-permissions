<?php

namespace App\Modules\AccessControl\Models;

use App\Modules\User\Models\User;
use Database\Factories\OrganizationalChartFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrganizationalChart extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    protected static function newFactory(): OrganizationalChartFactory
    {
        return OrganizationalChartFactory::new();
    }
}
