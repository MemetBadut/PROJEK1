<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BookUpdateRequest extends FormRequest
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
        $data = [];

        if ($this->has('nama_buku')) {
            $data['nama_buku'] = trim((string)$this->nama_buku);
        }

        if ($this->has('penulis_buku_id')) {
            $data['penulis_buku_id'] = (int) $this->penulis_buku_id;
        }

        if ($this->has('publisher_id')) {
            $data['publisher_id'] = (int) $this->publisher_id;
        }

        if ($this->has('isbn')) {
            $data['isbn'] = trim((string)$this->isbn);
        }

        if ($this->has('status_buku')) {
            $data['status_buku'] = strtolower(trim((string)$this->status_buku));
        }

        if ($this->has('sinopsis')) {
            $data['sinopsis'] = trim((string) $this->input('sinopsis'));
        }

        if ($this->has('slug')) {
            $data['slug'] = trim((string) $this->input('slug'));
        } elseif (array_key_exists('nama_buku', $data) && $data['nama_buku'] !== '') {
            $data['slug'] = Str::slug($data['nama_buku']);
        }

        if ($data !== []) {
            $this->merge($data);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $bookId = $this->route('book');
        return [
            'nama_buku'       => ['sometimes', 'required', 'string', 'max:255'],
            'penulis_buku_id' => ['sometimes', 'required', 'integer', 'exists:penulis_bukus,id'],
            'publisher_id'    => ['sometimes', 'required', 'integer', 'exists:publisher_bukus,id'],
            // ignore ID buku yang sedang diupdate agar ISBN-nya sendiri tetap valid
            'isbn'            => ['sometimes', 'required', 'string', 'max:20', "unique:produk_bukus,isbn,{$bookId}"],
            'status_buku'     => ['sometimes', 'required', 'string', 'in:tersedia,dipinjam,tersimpan'],
        ];
    }

    public function messages(): array
    {
        return [
            'penulis_buku_id.exists' => 'Penulis buku tidak ditemukan.',
            'publisher_id.exists'    => 'Publisher tidak ditemukan.',
            'isbn.unique'            => 'ISBN ini sudah digunakan oleh buku lain.',
            'status_buku.in'         => 'Status hanya boleh: tersedia, dipinjam, tersimpan.',
        ];
    }
}
