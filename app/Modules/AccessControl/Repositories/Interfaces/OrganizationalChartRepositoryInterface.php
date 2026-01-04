<?php

namespace App\Modules\AccessControl\Repositories\Interfaces;

use App\Modules\AccessControl\Data\OrganizationalChartData;
use App\Modules\AccessControl\Models\OrganizationalChart;
use Illuminate\Database\Eloquent\Collection;

interface OrganizationalChartRepositoryInterface
{
    public function all(array $relations = []): Collection;

    public function create(OrganizationalChartData $data): OrganizationalChart;

    public function update(OrganizationalChart $organizationalChart, OrganizationalChartData $data): bool;

    public function delete(OrganizationalChart $organizationalChart): bool;
}
