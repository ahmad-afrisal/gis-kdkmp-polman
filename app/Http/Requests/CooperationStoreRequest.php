<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CooperationStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'legal_entity_number' => 'nullable|string|max:255',
            'date_legal_entity_number' => 'nullable|date',
            'full_address' => 'required|string',
            'village_id' => 'required|exists:villages,id',
            'bussiness_assistant_id' => 'required|exists:bussiness_assistants,id', // sesuaikan nama tabel relasi BA
            'latitude' => 'nullable|string',
            'longtitude' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'principal_saving' => 'required|integer|min:0',
            'mandatory_saving' => 'required|integer|min:0',
            'subdomain' => 'required|string',

            // outlet flags
            'grocery_outlet' => 'required|boolean',
            'village_pharmacy_outlet' => 'required|boolean',
            'coopeative_office_outlet' => 'required|boolean',
            'savings_and_loan_outlet' => 'required|boolean',
            'village_clinic_outlet' => 'required|boolean',
            'cold_storage_outlet' => 'required|boolean',
            'logistics_outlet' => 'required|boolean',
            'fertilize_outlet' => 'required|boolean',
            'lpg_base_outlet' => 'required|boolean',
            'postal_agent_outlet' => 'required|boolean',
            'smart_agent_outlet' => 'required|boolean',

            'microsite_account' => 'boolean',
            'nib' => 'boolean',
            'leader_name' => 'nullable|string|max:255',
        ];
    }


    /**
     * Pesan error kustom (opsional).
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama koperasi wajib diisi.',
            'full_address.required' => 'Alamat lengkap wajib diisi.',
            'village_id.required' => 'Desa wajib dipilih.',
            'bussiness_assistant_id.required' => 'Asisten Bisnis wajib dipilih.',
            'principal_saving.required' => 'Simpanan pokok wajib diisi.',
            'mandatory_saving.required' => 'Simpanan wajib wajib diisi.',
        ];
    }
}
