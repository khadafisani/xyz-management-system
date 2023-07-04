<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'customer.address' => 'required|string',
            'customer.subdistrict' => 'required|string',
            'customer.city' => 'required|string',
            'customer.province' => 'required|string',
        ];
    }
}
