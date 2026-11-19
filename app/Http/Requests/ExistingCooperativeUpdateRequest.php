<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ExistingCooperativeUpdateRequest extends ExistingCooperativeStoreRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $id = $this->route('existing_cooperative');
        $rules['nik'] = ['required', 'string', 'max:255', Rule::unique('existing_cooperatives', 'nik')->ignore($id)];
        $rules['legal_entity_number'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('existing_cooperatives', 'legal_entity_number')->ignore($id),
        ];

        return $rules;
    }
}
