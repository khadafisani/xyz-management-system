<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoruController extends Controller
{
    public function index()
    {
        $service = ServiceCategory::all();
        return response()->api($service, 200, 'Sucessfully retrieve service categories');
    }

    public function store(Request $request)
    {
        $data = $request->validated();

        \DB::beginTransaction();
        try {
            $serviceCategory = ServiceCategory::create($data);

            \DB::commit();
            return response()->api($serviceCategory, 200, 'Sucessfully store service category');
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->api([], 400, 'Failed to store service');
        }
    }

    public function show(ServiceCategory $serviceCategory)
    {
        return response()->api($serviceCategory, 200, 'Sucessfully retrieve service category');
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $data = $request->validated();

        \DB::beginTransaction();
        try {
            $serviceCategory->update($data);

            \DB::commit();
            return response()->api($serviceCategory, 200, 'Sucessfully update service category');
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->api([], 400, 'Failed to update service');
        }
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        $serviceCategory->delete();
        return response()->api([], 200, 'Sucessfully delete service category');
    }
}
