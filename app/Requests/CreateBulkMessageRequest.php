<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class CreateBulkMessageRequest extends FormRequest
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
            'user_type_code' => 'required|string|min:5|max:5|exists:user_types,code',
            'content' => 'required|string|min:1|max:150',
            'messageReceivers' => 'nullable|array'
        ];
    }
}
