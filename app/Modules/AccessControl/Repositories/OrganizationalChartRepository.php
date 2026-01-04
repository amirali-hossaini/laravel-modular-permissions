<?php

namespace App\Modules\AccessControl\Repositories;

use App\Modules\AccessControl\Data\OrganizationalChartData;
use App\Modules\AccessControl\Models\OrganizationalChart;
use App\Modules\AccessControl\Repositories\Interfaces\OrganizationalChartRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

readonly class OrganizationalChartRepository implements OrganizationalChartRepositoryInterface
{
    public function all(array $relations = []): Collection
    {
        return OrganizationalChart::with($relations)->get();
    }

    public function create(OrganizationalChartData $data): OrganizationalChart
    {
        return DB::transaction(function () use ($data) {
            $chart = OrganizationalChart::create($data->toArray());

            $chart->permissions()->attach($data->permissionIds);

            return $chart;
        });
    }

    public function update(OrganizationalChart $chart, OrganizationalChartData $data): bool
    {
        return DB::transaction(function () use ($chart, $data) {
            $updated = $chart->update($data->toArray());

            $chart->permissions()->sync($data->permissionIds);

            return $updated;
        });
    }

    public function delete(OrganizationalChart $chart): bool
    {
        return $chart->delete();
    }
}
