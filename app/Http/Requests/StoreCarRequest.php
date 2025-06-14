<?php

namespace App\Http\Requests;

use App\Enums\FuelType;
use App\Enums\Status;
use App\Enums\Transmission;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class StoreCarRequest extends FormRequest
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
        return [
            'car_model_id' => 'integer|required|exists:car_models,id',
            'price_per_day' => 'numeric|required|min:1|max:100000',
            'description' => 'string',
            'seats' => 'integer|required',
            'year' => 'required|integer|min:2000|max:' . now()->year,
            'fuel_type' => ['required', Rule::enum(FuelType::class)],
            'transmission' => ['required', Rule::enum(Transmission::class)],
            'status' => ['required', Rule::enum(Status::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'car_model_id.required' => 'Car modeli mütləq seçilməlidir.',
            'car_model_id.exists' => 'Seçilmiş car modeli bazada yoxdur.',
            'price_per_day.required' => 'Gündəlik qiymət daxil edilməlidir.',
            'price_per_day.numeric' => 'Qiymət rəqəm olmalıdır.',
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
