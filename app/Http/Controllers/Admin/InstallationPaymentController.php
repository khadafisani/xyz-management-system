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
        $installationPayments = InstallationPayment::with(['installation.user'])->search();

        $result = [
            'count' => $installationPayments->count(),
            'data' => $installationPayments->getResult(),
        ];
        return response()->api($result, 200, 'ok', 'Sucessfully retrieve installation payments');
    }

    public function show(InstallationPayment $installation_payment)
    {
        return response()->api($installation_payment->load('installation.user'), 200, 'ok', 'Sucessfully get installation');
    }

    public function paid(InstallationPayment $installation_payment)
    {
        if($installation_payment->status->value !== InstallationPaymentStatus::SUBMITTED->value) {
            return response()->api([], 400, 'ok', 'Installation already paid or rejected');
        }
        $installation_payment->status = InstallationPaymentStatus::PAID;
        $installation_payment->save();
        return response()->api($installation_payment->load('installation.user'), 200, 'ok', 'Successfully paid installation payment');
    }

    public function reject(InstallationPayment $installation_payment)
    {
        if($installation_payment->status->value !== InstallationPaymentStatus::SUBMITTED->value) {
            return response()->api([], 400, 'ok', 'Installation already finish or rejected');
        }
        $installation_payment->status = InstallationPaymentStatus::REJECTED;
        $installation_payment->save();
        return response()->api($installation_payment->load('installation.user'), 200, 'ok', 'Successfully reject installation payment');
    }
}
