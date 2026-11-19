<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CooperationImageStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'Pilih minimal satu gambar.',
            'images.array' => 'Format unggahan gambar tidak valid.',
            'images.min' => 'Pilih minimal satu gambar.',
            'images.*.image' => 'Setiap file harus berupa gambar.',
            'images.*.mimes' => 'Gambar harus berformat JPG, JPEG, PNG, atau WEBP.',
            'images.*.max' => 'Ukuran setiap gambar maksimal 10 MB.',
        ];
    }
}
