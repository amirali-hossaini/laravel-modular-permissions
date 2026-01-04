<?php

namespace App\Modules\AccessControl\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AccessControl\Data\OrganizationalChartData;
use App\Modules\AccessControl\Http\Requests\OrganizationalChartRequest;
use App\Modules\AccessControl\Http\Resources\OrganizationalChartResource;
use App\Modules\AccessControl\Http\Resources\OrganizationalChartThumbResource;
use App\Modules\AccessControl\Models\OrganizationalChart;
use App\Modules\AccessControl\Repositories\Interfaces\OrganizationalChartRepositoryInterface;
use App\Modules\AccessControl\Services\AccessControlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OrganizationalChartController extends Controller
{
    public function __construct(
        private readonly AccessControlService $accessControlService,
        private readonly OrganizationalChartRepositoryInterface $chartRepository,
    ) {}

    public function index(): JsonResponse
    {
        $this->accessControlService->isAbleTo('access_control.organizational_charts.index');

        $charts = $this->chartRepository->all();

        return apiResponse()
            ->data($charts)
            ->jsonResource(OrganizationalChartResource::class)
            ->get();
    }

    public function store(OrganizationalChartRequest $request): JsonResponse
    {
        $this->accessControlService->isAbleTo('access_control.organizational_charts.store');

        $chart = $this->chartRepository->create(OrganizationalChartData::from($request->validated()));

        return apiResponse()
            ->data($chart)
            ->jsonResource(OrganizationalChartResource::class)
            ->message('The new organizational chart has been successfully created.')
            ->status(Response::HTTP_CREATED)
            ->get();
    }

    public function show(OrganizationalChart $organizationalChart): JsonResponse
    {
        $this->accessControlService->isAbleTo('access_control.organizational_charts.show');

        return apiResponse()
            ->data($organizationalChart->load('permissions'))
            ->jsonResource(OrganizationalChartThumbResource::class)
            ->get();
    }

    public function update(OrganizationalChart $organizationalChart, OrganizationalChartRequest $request): JsonResponse
    {
        $this->accessControlService->isAbleTo('access_control.organizational_charts.update');

        $this->chartRepository->update($organizationalChart, OrganizationalChartData::from($request->validated()));

        return apiResponse()->message('The organizational chart has been successfully updated.')->get();
    }

    public function destroy(OrganizationalChart $organizationalChart): JsonResponse
    {
        $this->accessControlService->isAbleTo('access_control.organizational_charts.destroy');

        $this->chartRepository->delete($organizationalChart);

        return apiResponse()->message('The organizational chart has been successfully deleted.')->get();
    }
}
