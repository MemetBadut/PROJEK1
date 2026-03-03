<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexRatingRequest extends FormRequest
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
            'year' => $this->year ? trim($this->year) : null,
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
            'year' => ['sometimes', 'integer', 'digits:4'],
        ];
    }

    public function messages(): array
    {
        return [
            'year.digits' => 'Tahun harus tepat 4 digit, contoh: 2020',
            'year.integer' => 'Tahun harus berupa angka!',
        ];
    }
}
