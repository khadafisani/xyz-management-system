<?php

namespace App\Http\Controllers\Admin;

use App\Models\InstallationPayment;
use App\Models\Service;
use App\Http\Enums\InstallationPaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstallationPaymentRequest;
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

    public function show(InstallationPayment $installation_payment)
    {
        return response()->api($installation_payment->load('installation.user'), 200, 'ok', 'Sucessfully get installation');
    }

    public function paid(InstallationPayment $installation_payment)
    {
        if($installation_payment->status !== InstallationPaymentStatus::SUBMITTED->value) {
            return response()->api([], 400, 'ok', 'Installation already finish or rejected');
        }
        $installation_payment->status = InstallationPaymentStatus::PAID;
        $installation_payment->save();
        return response()->api($installation_payment->load('installation.user'), 200, 'ok', 'Installation in progress');
    }

    public function reject(InstallationPayment $installation_payment)
    {
        if($installation_payment->status !== InstallationPaymentStatus::SUBMITTED->value) {
            return response()->api([], 400, 'ok', 'Installation already finish or rejected');
        }
        $installation_payment->status = InstallationPaymentStatus::REJECTED;
        $installation_payment->save();
        return response()->api($installation_payment->load('installation.user'), 200, 'ok', 'Installation in progress');
    }
}
