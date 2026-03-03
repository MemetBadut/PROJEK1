<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRatingRequest extends FormRequest
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
            'produk_buku_id' => $this->produk_buku_id ? (int)$this->produk_buku_id : null,
            'ratings' => $this->ratings ? (int)$this->ratings : null,
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
            'produk_buku_id' => ['required', 'integer', 'exists:produk_bukus,id'],
            'ratings' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }

    public function messages()
    {
        return [
            'produk_buku_id.required' => 'produk_buku_id wajib disertakan.',
            'produk_buku_id.exists'   => 'Buku tidak ditemukan.',
            'ratings.required'        => 'Rating wajib diisi.',
            'ratings.min'             => 'Rating minimal 1.',
            'ratings.max'             => 'Rating maksimal 10.',
        ];
    }
}
