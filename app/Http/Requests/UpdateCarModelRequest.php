<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateCarModelRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'brand_id'=>'required|integer|exists:brands,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('car_models', 'name')->ignore($this->route('model')->id)
            ],
            'is_active' => 'in:0,1'
        ];
    }

    public function messages():array
    {
        return [
            'name.required'=>'Ad bos buraxila bilmez',
            'brand_id.required'=>'Brend bos buraxila bilmez',
            'name.unique'=>'Ad artiq movcuddur'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
        throw new ValidationException($validator, $response);
    }
}
