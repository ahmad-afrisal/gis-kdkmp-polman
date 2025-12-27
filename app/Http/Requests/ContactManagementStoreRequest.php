<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactManagementStoreRequest extends FormRequest
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
            'cooperation_id' => 'required|exists:cooperations,id',
            'leader_name' => 'nullable|string',
            'leader_phone_number' => 'nullable|string',
            'name_of_deputy_member' => 'nullable|string',
            'deputy_member_phone_number' => 'nullable|string',
            'name_of_deputy_business' => 'nullable|string',
            'deputy_business_phone_number' => 'nullable|string',
            'name_of_secretary' => 'nullable|string',
            'secretary_phone_number' => 'nullable|string',
            'name_of_treasurer' => 'nullable|string',
            'treasurer_phone_number' => 'nullable|string',
        ];
    }
}
