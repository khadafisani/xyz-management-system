<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstallationRequest extends FormRequest
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
            'note' => 'string',
            'proof' => 'required|file|mimes:png,jpg,jpeg',
            'service_id' => 'required|exists:services,id',
            'address' => 'required|string',
            'date' => 'required|date',
        ];
    }
}
