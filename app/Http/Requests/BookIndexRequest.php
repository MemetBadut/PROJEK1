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
            'per_page' => $this->per_page ? (int)$this->per_page : 20
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
            'sorting' => ['nullable', 'string', 'in:most,least,name_asc,name_desc'],
            'status' => ['nullable', 'string', 'in:tersedia,dipinjam,tersimpan'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'sorting.in'   => 'Urutan hanya boleh: most, least, name_asc, name_desc.',
            'status.in'    => 'Status buku hanya boleh: tersedia, dipinjam, tersimpan.',
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
            'per_page' => 'jumlah per halaman',
        ];
    }
}
