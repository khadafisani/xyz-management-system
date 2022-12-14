<?php

namespace App\Http\Controllers;

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

        if($installation->status !== InstallationStatus::FINISH->value) {
            return response()->api([], 400, 'error', 'Installation not completed / finish');
        }

        if($data['amount'] !== $installation->service->amount) {
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

    public function show(InstallationPayment $installationPayment)
    {
        if($installationPayment->installation->user_id == auth()->user()->id) {
            throw (new ModelNotFoundException())->setModel(Installation::class);
        }
        return response()->api($installationPayment->load('installation.user'), 200, 'ok', 'Sucessfully get installation Payment');
    }
}
