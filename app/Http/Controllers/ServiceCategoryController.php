<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use App\Http\Requests\CreateServiceCategoryRequest;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $service = ServiceCategory::all();
        return response()->api($service, 200, 'ok', 'Sucessfully retrieve service categories');
    }

    public function store(CreateServiceCategoryRequest $request)
    {
        $data = $request->validated();

        \DB::beginTransaction();
        try {
            $serviceCategory = ServiceCategory::create($data);

            \DB::commit();
            return response()->api($serviceCategory, 200, 'ok', 'Sucessfully store service category');
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->api([], 400, 'error', 'Failed to store service');
        }
    }

    public function show(ServiceCategory $service_category)
    {
        return response()->api($service_category, 200, 'ok', 'Sucessfully retrieve service category');
    }

    public function update(CreateServiceCategoryRequest $request, ServiceCategory $service_category)
    {
        $data = $request->validated();

        \DB::beginTransaction();
        try {
            $service_category->update($data);

            \DB::commit();
            return response()->api($service_category, 200, 'ok', 'Sucessfully update service category');
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->api([], 400, 'error', 'Failed to update service');
        }
    }

    public function destroy(ServiceCategory $service_category)
    {
        $service_category->delete();
        return response()->api([], 200, 'ok', 'Sucessfully delete service category');
    }
}
