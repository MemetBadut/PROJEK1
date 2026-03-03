<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'nama_buku' => $this->nama_buku ? trim($this->nama_buku) : null,
            'isbn' => $this->isbn ? trim($this->isbn) : null,
            'penulis_buku_id' => $this->penulis_buku_id ? (int)$this->penulis_buku_id : null,
            'publisher_id' => $this->publisher_id ? (int)$this->publisher_id : null,
            'status_buku' => $this->status_buku ? trim($this->status_buku) : null,
            'slug' => $this->slug ? trim($this->slug) : null,
            'sinopsis' => $this->sinopsis ? trim($this->sinopsis) : null,
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
            'nama_buku'       => ['required', 'string', 'max:255'],
            'penulis_buku_id' => ['required', 'integer', 'exists:penulis_bukus,id'],
            'publisher_id'    => ['required', 'integer', 'exists:publisher_bukus,id'],
            'isbn'            => ['required', 'string', 'max:20', 'unique:produk_bukus,isbn'],
            'status_buku'     => ['required', 'string', 'in:tersedia,dipinjam,tersimpan'],
            'slug'            => ['required', 'string', 'max:255', 'unique:produk_bukus,slug'],
            'sinopsis'        => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_buku.required'        => 'Nama buku wajib diisi.',
            'penulis_buku_id.required'  => 'Penulis buku wajib dipilih.',
            'penulis_buku_id.exists'    => 'Penulis buku tidak ditemukan di database.',
            'publisher_id.required'     => 'Publisher buku wajib dipilih.',
            'publisher_id.exists'       => 'Publisher tidak ditemukan di database.',
            'isbn.required'             => 'ISBN buku wajib diisi.',
            'isbn.unique'               => 'ISBN ini sudah digunakan oleh buku lain.',
            'status_buku.in'            => 'Status hanya boleh: tersedia, dipinjam, tersimpan.',
            'slug.required'             => 'Slug buku wajib diisi.',
            'slug.unique'               => 'Slug ini sudah digunakan oleh buku lain.',
            'sinopsis.required'         => 'Sinopsis buku wajib diisi.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_buku'       => 'nama buku',
            'penulis_buku_id' => 'penulis',
            'publisher_id'    => 'publisher',
            'isbn'            => 'ISBN',
            'status_buku'     => 'status buku',
            'slug'            => 'slug',
            'sinopsis'        => 'sinopsis',
        ];
    }
}
