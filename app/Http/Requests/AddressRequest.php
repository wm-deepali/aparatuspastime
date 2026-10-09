<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => ['required', 'digits:10'],
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'state_id'       => 'required|exists:states,id',
            'city_id'        => 'required|exists:cities,id',
            'pincode'        => ['required', 'digits:6'],
            'address_type'   => 'nullable|in:home,work,other',
            'is_default'     => 'nullable|boolean',
        ];
    }
}