<?php

namespace App\Http\Controllers\Admin;

use App\Models\Installation;
use App\Models\Service;
use App\Http\Enums\InstallationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstallationRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Storage;

class InstallationController extends Controller
{
    public function index()
    {
        $installations = Installation::with(['service.service_category'])->search();
        $result = [
            'count' => $installations->count(),
            'data' => $installations->getResult(),
        ];
        return response()->api($result, 200, 'ok', 'Sucessfully get installations');
    }

    public function show(Installation $installation)
    {
        return response()->api($installation->load('service'), 200, 'ok', 'Sucessfully get installation');
    }

    public function proceed(Installation $installation)
    {
        if($installation->status->value !== InstallationStatus::SUBMITTED->value) {
            return response()->api([], 400, 'ok', 'Installation already proceed');
        }
        $installation->status = InstallationStatus::PROCEED;
        $installation->save();
        return response()->api($installation->load('service'), 200, 'ok', 'Installation in progress');
    }

    public function finish(Installation $installation)
    {
        if($installation->status->value !== InstallationStatus::PROCEED->value) {
            return response()->api([], 400, 'ok', 'Installation already finish or rejected');
        }
        $installation->status = InstallationStatus::FINISH;
        $installation->save();
        return response()->api($installation->load('service'), 200, 'ok', 'Installation in completed');
    }

    public function reject(Installation $installation)
    {
        if($installation->status->value !== InstallationStatus::PROCEED->value) {
            return response()->api([], 400, 'ok', 'Installation already finish or rejected');
        }
        $installation->status = InstallationStatus::REJECTED;
        $installation->save();
        return response()->api($installation->load('service'), 200, 'ok', 'Installation in progress');
    }
}
