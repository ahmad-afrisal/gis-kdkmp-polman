<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CooperationUpdateRequest extends CooperationStoreRequest
{
    /**
     * Aturan validasi untuk update.
     */
    public function rules(): array
    {
        // Ambil semua rules dari CooperationRequest
        $rules = parent::rules();

        // Misalnya kamu punya validasi unik (jika nanti ditambahkan)
        // Contoh: legal_entity_number harus unik kecuali untuk data yang sedang diupdate
        $cooperationId = $this->route('cooperation'); // sesuaikan nama parameter di route kamu

        $rules['legal_entity_number'] = [
            'nullable',
            'string',
            'max:255',
            Rule::unique('cooperations', 'legal_entity_number')->ignore($cooperationId),
        ];

        // Jika ada field yang tidak wajib di-update (misalnya email)
        $rules['email'] = 'nullable|email|max:255';

        return $rules;
    }
}
