<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookIndexRequest extends FormRequest
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

    protected function prepForValidation()
    {
        $this->merge([
            'status_buku' => $this->status_buku ?? 'tersedia',
            ''
        ]);
    }
    public function rules(): array
    {
        return [
            'nama_buku' => ['required', 'string', 'max:255'],
            'status_buku' => ['required', 'in:tersedia,dipinjam,tersimpan'],
            ''
        ];
    }
}
