<?php

namespace App\Domain\Libraries\Bbks\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBbkRequest extends FormRequest
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
            'sub_id' => 'sometimes|exists:library_bbks,id',
            'code' => 'required|integer',
            'name' => 'required|string',
            'info' => 'required|string',
            'is_active' => 'required',
            'lib_bbk' => 'sometimes|json',
        ];
    }
}
