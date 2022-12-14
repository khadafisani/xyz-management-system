<?php

namespace App\Http\Controllers\Admin;

use App\Models\InstallationPayment;
use App\Models\Service;
use App\Http\Enums\InstallationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstallationRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Storage;

class InstallationPaymentController extends Controller
{
    public function index()
    {
        $installationPayments = InstallationPayment::with(['installation.user'])->search()->getResult();
        return response()->api($installationPayments, 200, 'ok', 'Sucessfully get installation payments');
    }

    public function show(InstallationPayment $installationPayment)
    {
        return response()->api($installationPayment->load('installation.user'), 200, 'ok', 'Sucessfully get installation');
    }

    public function paid(InstallationPayment $installationPayment)
    {
        if($installationPayment->status !== InstallationPaymentStatus::SUBMITTED->value) {
            return response()->api([], 400, 'ok', 'Installation already finish or rejected');
        }
        $installationPayment->status = InstallationPaymentStatus::PAID;
        $installationPayment->save();
        return response()->api($installationPayment->load('installation'), 200, 'ok', 'Installation in progress');
    }

    public function reject(InstallationPayment $installationPayment)
    {
        if($installationPayment->status !== InstallationPaymentStatus::SUBMITTED->value) {
            return response()->api([], 400, 'ok', 'Installation already finish or rejected');
        }
        $installationPayment->status = InstallationPaymentStatus::REJECTED;
        $installationPayment->save();
        return response()->api($installationPayment->load('installation'), 200, 'ok', 'Installation in progress');
    }
}
