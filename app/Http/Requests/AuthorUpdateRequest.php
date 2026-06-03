<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    protected function prepareForValidation() :void
    {
        if($this->has('nama_penulis')){
            $this->merge(['nama_penulis' => trim((string) $this->nama_penulis)]);
        }
    }
    public function rules(): array
    {
        return [
            'nama_penulis' => ['sometimes', 'required', 'string', 'max:255'],
        ];
    }
}
