<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OnlineAttendanceStoreRequest extends FormRequest
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
            'bussiness_assistant_id' => 'required|exists:bussiness_assistants,id',
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'activity' => 'required|string',
        
        ];
    }
}
