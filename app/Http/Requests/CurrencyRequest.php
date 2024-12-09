<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CurrencyRequest",
 *     type="object",
 *     title="Currency Request",
 *     required={"name"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre del rol"
 *     )
 * )
 */

class CurrencyRequest extends FormRequest
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
                    'code' => 'required|string|max:3|unique:currency,code',
                    'name' => 'required|string|max:255|unique:currency.name',
                    'symbol' => 'nullable|string|max:10|unique:currency.symbol'
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
            'code.required' => 'El codigo de la moneda es obligatorio.',
            'name.required' => 'El nombre de la moneda es obligatorio.',
            'symbol.required' => 'El simbolo de la moneda es obligatorio.',
        ];
    }
}
