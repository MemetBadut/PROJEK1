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
            //
        ];
    }
}
