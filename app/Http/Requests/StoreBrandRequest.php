<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreBrandRequest extends FormRequest
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
            'name'=> 'required|string|max:255|unique:brands,name',
            'is_active' =>'required|in:0,1'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' =>'Brend adı boş buraxıla bilməz',
            'name.unique' =>'Brend adı artıq mövcuddur.',
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
