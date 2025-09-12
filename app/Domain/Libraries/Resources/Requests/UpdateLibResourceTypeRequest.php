<?php

namespace App\Domain\Libraries\Resources\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLibResourceTypeRequest extends FormRequest
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
            'name' => 'required|string',
            'lib_resource_type' => 'sometimes|json'
        ];
    }
}
