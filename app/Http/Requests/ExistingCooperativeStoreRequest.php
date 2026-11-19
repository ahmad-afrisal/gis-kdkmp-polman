<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExistingCooperativeStoreRequest extends FormRequest
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
            'nik' => ['required', 'string', 'max:255', Rule::unique('existing_cooperatives', 'nik')],
            'name' => ['required', 'string', 'max:255'],
            'legal_entity_number' => ['required', 'string', 'max:255', Rule::unique('existing_cooperatives', 'legal_entity_number')],
            'form_of_cooperative' => ['required', Rule::in(['Primer', 'Sekunder'])],
            'type_of_cooperative' => ['required', 'string', 'max:255'],
            'management_model' => ['required', Rule::in(['Konvensional', 'Syariah'])],
            'cooperative_status_id' => ['required', 'exists:cooperative_statuses,id'],
            'business_activity_id' => ['required', 'exists:business_activities,id'],
            'cooperative_group' => ['required', 'string', 'max:255'],
            'district_id' => ['required', 'exists:districts,id'],
            'village_id' => [
                'required',
                Rule::exists('villages', 'id')->where('district_id', $this->input('district_id')),
            ],
            'address' => ['required', 'string'],
            'latitude' => ['nullable', 'required_with:longitude', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'required_with:latitude', 'numeric', 'between:-180,180'],
            'postal_code' => ['required', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'number_of_members' => ['required', 'integer', 'min:0'],
            'chairperson_name' => ['nullable', 'string', 'max:255'],
            'secretary_name' => ['nullable', 'string', 'max:255'],
            'treasurer_name' => ['nullable', 'string', 'max:255'],
            'vice_chairperson_membership_name' => ['nullable', 'string', 'max:255'],
            'vice_chairperson_business_operations_name' => ['nullable', 'string', 'max:255'],
            'head_supervisory_board_name' => ['nullable', 'string', 'max:255'],
            'member_supervisory_board_i_name' => ['nullable', 'string', 'max:255'],
            'member_supervisory_board_ii_name' => ['nullable', 'string', 'max:255'],
        ];
    }
}
