<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'nama_penulis' => $this->nama_penulis ? trim($this->nama_penulis) : null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'sometimes' = hanya validasi kalau field ini dikirim
            'nama_penulis' => ['sometimes', 'required', 'string', 'max:255'],
        ];
    }
    public function messages()
    {
        return [
            'nama_penulis.required' => 'Nama penulis wajib diisi jika dikirim.',
        ];
    }
}
