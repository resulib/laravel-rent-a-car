<?php

namespace App\Http\Requests;

use App\Enums\FuelType;
use App\Enums\Status;
use App\Enums\Transmission;
use Doctrine\Common\Annotations\Annotation\Enum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarRequest extends FormRequest
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
            'car_model_id' => 'sometimes|exists:car_models,id',
            'price_per_day' => 'sometimes|numeric|min:1',
            'description' => 'sometimes|string|nullable',
            'seats' => 'sometimes|integer|min:1',
            'year' => 'sometimes|integer|digits:4',
            'fuel_type' => ['sometimes', Rule::enum(FuelType::class)],
            'transmission' => ['sometimes', Rule::enum(Transmission::class)],
            'status' => ['sometimes', Rule::enum(Status::class)],
        ];
    }
}
