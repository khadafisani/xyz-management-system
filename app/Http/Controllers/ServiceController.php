<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $service = Service::all();
        return response()->api($service, 200, 'ok', 'Sucessfully get service');
    }

    public function store(Request $request)
    {
        $data = $request->validated();

        \DB::beginTransaction();
        try {
            $service = Service::create($data);

            \DB::commit();
            return response()->api($service, 200, 'ok', 'Sucessfully store service');
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->api([], 400, 'error', 'Failed to store service');
        }
    }

    public function show(Service $service)
    {
        return response()->api($service, 200, 'ok', 'Sucessfully get service');
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validated();

        \DB::beginTransaction();
        try {
            $service->update($data);

            \DB::commit();
            return response()->api($service, 200, 'ok', 'Sucessfully update service');
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->api([], 400, 'error', 'Failed to update service');
        }
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return response()->api([], 200, 'ok', 'Sucessfully delete service');
    }
}
