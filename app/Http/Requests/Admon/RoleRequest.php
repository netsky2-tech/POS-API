<?php

namespace App\Http\Requests\Admon;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RoleRequest",
 *     type="object",
 *     title="Role Request",
 *     required={"name"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre del rol"
 *     )
 * )
 */

class RoleRequest extends FormRequest
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
                    'name' => 'required|string|max:255|unique:roles,name',
                    'created_by' => 'string'
                ];
                break;

            case 'PUT':
                $rules = [
                    'name' => 'required|string|unique:roles,name',
                ];
                break;

            case 'PATCH':
                $rules = [
                    'name' => 'required|string|max:255|unique:roles,name,' . $this->route('v1.roles.update'),
                    'permissions' => 'array|exists:permissions,id',
                ];
                break;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'per_page.max' => 'El número máximo de elementos por página es 100.',
        ];
    }
}
