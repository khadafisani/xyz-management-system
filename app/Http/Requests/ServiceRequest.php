<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'installation_fee' => 'required|numeric',
            'quote_every_month' => 'required|numeric',
            'service_category_id' => 'required|exists:service_categories,id',
            'download_speed' => 'numeric|nullable',
            'upload_speed' => 'numeric|nullable'
        ];
    }
}
