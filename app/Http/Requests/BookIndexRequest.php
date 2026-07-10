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

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->status ?? null,
            'search' => $this->search ? trim($this->search) : null,
            'per_page' => $this->filled('per_page') ? (int) $this->input('per_page') : null,
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
            'search' => ['nullable', 'string', 'max:100'],
            'sorting' => ['nullable', 'string', 'in:most,least,rating_desc,rating_asc,name_asc,name_desc'],
            'status' => ['nullable', 'string', 'in:available,rented,reserved'],
            'lokasi_toko_id' => ['nullable', 'integer', 'exists:lokasi_toko,id'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'sorting.in'   => 'Pilihan urutan buku tidak valid.',
            'status.in'    => 'Status buku hanya boleh: available, rented, atau reserved.',
            'lokasi_toko_id.exists' => 'Lokasi toko tidak ditemukan.',
            'per_page.min' => 'Jumlah per halaman minimal 1.',
            'per_page.max' => 'Jumlah per halaman maksimal 100.',
            'search.max'   => 'Keyword pencarian maksimal 100 karakter.',
        ];
    }

    public function attributes()
    {
        return [
            'search'   => 'kata kunci pencarian',
            'sorting'  => 'urutan',
            'status'   => 'status buku',
            'lokasi_toko_id' => 'lokasi toko',
            'per_page' => 'jumlah per halaman',
        ];
    }
}
