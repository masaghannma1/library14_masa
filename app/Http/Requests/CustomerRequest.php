<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    $customer = $this->route('customer'); 
     return [ 'name' => 'required|string|max:255',
    'gender' => 'nullable|in:M,F',
    'DOB' => 'nullable|date', 
    'phone' => 'required|string|unique:customers,phone,' . $customer?->id,
    'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
    'lang' => 'required|in:ar,en', ];

}
}
