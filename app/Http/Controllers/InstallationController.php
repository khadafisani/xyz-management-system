<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\Service;
use App\Http\Enums\InstallationStatus;
use App\Http\Requests\InstallationRequest;
use Illuminate\Http\Request;
use Storage;

class InstallationController extends Controller
{
    public function index()
    {
        $installations = Installation::all();
        return response()->api($installations, 200, 'ok', 'Sucessfully get installations');
    }

    public function store(InstallationRequest $request)
    {
        $data = $request->validated();
        \DB::beginTransaction();
        try {
            if(isset($data['proof'])) {
                $data['file_path'] = Storage::disk('public')->put('installation_proof', $data['proof']);
            }

            $installation = Installation::create([
                ...$data,
                'installation_fee' => Service::find($data['service_id'])->installation_fee,
                'user_id' => auth()->user()->id,
                'status' => InstallationStatus::SUBMITTED,
            ]);

            \DB::commit();
            return response()->api($installation->load('service'), 200, 'ok', 'Sucessfully store installation');
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->api([], 400, 'error', 'Failed to store installation');
        }
    }

    public function show(Installation $installation)
    {
        return response()->api($installation->load('service'), 200, 'ok', 'Sucessfully get installation');
    }
}
