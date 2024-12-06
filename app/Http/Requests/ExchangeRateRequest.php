<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ExchangeRateRequest",
 *     type="object",
 *     title="Exchange Request",
 *     required={"name"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre del rol"
 *     )
 * )
 */

class ExchangeRateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [];

        switch ($this->method()) {

            case 'GET':
                $rules = [
                    'page' => 'nullable|integer|min:1',
                    'per_page' => 'nullable|integer|min:1|max:100',
                ];
                break;

            case 'POST':
                $rules = [
                    'base_currency_id' => 'required|integer|min:1|unique:currency,base_currency_id',
                    'target_currency_id' => 'required|integer|min:1|unique:currency,target_currency_id',
                    'exchange_rate' => 'required|decimal|min:0',
                    'valid_from' => 'required|date|max:10',
                ];
                break;

            case 'PUT':
                $rules = [
                    'id' => 'required|integer|min:1',
                    'data' => 'required|array'
                ];
                break;

            case 'DELETE':
                $rules = [
                    'id' => 'required|integer|min:1',
                ];
                break;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'id.required' => 'El ID es obligatorio.',
            'data.required' => 'Digite los campos requeridos para crear una nueva moneda.',
            'base_currency_id.required' => 'La moneda base es requerida.',
            'target_currency_id.required' => 'La moneda destino es requerida..',
            'exchange_rate.required' => 'El tipo de cambio es requerido.',
            'valid_from.required' => 'La fecha es requerida.',
        ];
    }
}
