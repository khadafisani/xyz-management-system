<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\InstallationPayment;
use App\Http\Enums\InstallationStatus;
use App\Http\Enums\InstallationPaymentStatus;
use App\Http\Requests\InstallationPaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Storage;

class InstallationPaymentController extends Controller
{
    public function index()
    {
        $installations = InstallationPayment::with('installations.user')->whereHas('installations', function($query) {
           return $query->where('user_id', auth()->user()->id);
        })->search()->getResult();
        return response()->api($installations, 200, 'ok', 'Sucessfully get installations');
    }

    public function store(InstallationPaymentRequest $request, Installation $installation)
    {
        $data = $request->validated();

        if($installation->status->value !== InstallationStatus::FINISH->value) {
            return response()->api([], 400, 'error', 'Installation not completed / finish');
        }

        if($installation->date > $data['date']) {
            return response()->api([], 400, 'error', 'cannot make payment, installation created at ' . $installation->date);
        }

        $month = date('m', strtotime($data['date']));
        $year = date('Y', strtotime($data['date']));
        $paymentExist = InstallationPayment::whereMonth('date', $month)->whereYear('date', $year)->where('status', InstallationPaymentStatus::PAID)->first();

        if($paymentExist) {
            return response()->api([], 400, 'error', 'Installation at ' . $month . '-' . $year . ' Already paid');
        }

        if($data['amount'] != $installation->service->amount) {
            return response()->api([], 400, 'error', 'Incorrect payment amount, please recheck or contact admin');
        }

        $filePath = Storage::disk('public')->put('installation_payment_proof', $data['proof']);

        $installationPayment = new InstallationPayment();
        $installationPayment->fill($data);
        $installationPayment->amount = $installation->service->amount;
        $installationPayment->status = InstallationPaymentStatus::SUBMITTED;
        $installationPayment->file_path = $filePath;
        $installationPayment->installation_id = $installation->id;
        $installationPayment->save();

        return response()->api($installationPayment, 200, 'ok', 'Successfully paid recurring payment');
    }

    public function show(InstallationPayment $installation_payment)
    {
        if($installation_payment->installation->user_id == auth()->user()->id) {
            throw (new ModelNotFoundException())->setModel(Installation::class);
        }
        return response()->api($installation_payment->load('installation.user'), 200, 'ok', 'Sucessfully get installation Payment');
    }
}
