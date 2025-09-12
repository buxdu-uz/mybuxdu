<?php

namespace App\Domain\Libraries\Books\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLibBookRequest extends FormRequest
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
            'humen_id' => 'nullable',
            'lib_resource_type_id' => 'required|exists:lib_resource_types,id',
            'lib_publishing_id' => 'required|exists:lib_publishings,id',
            'lib_bbk_id' => 'required|exists:lib_bbks,id',
            'annotation' => 'nullable',
            'name' => 'required|string',
            'author' => 'required|string',
            'number' => 'required|numeric',
            'is_active' => 'required|boolean',
            'page' => 'required|integer',
            'image' => 'nullable|string',
            'price' => 'required|numeric',
            'release_date' => 'nullable|string',
            'lib_book' => 'sometimes|json',
        ];
    }
}
