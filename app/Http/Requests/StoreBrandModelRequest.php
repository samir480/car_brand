<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandModelRequest extends FormRequest
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
    public function rules(): array
    {
        $rules = [
            'name' => 'required|max:255|unique:brand_models,name,NULL,id,brand_id,'.$this->brand_id,
            'brand_id' => 'required|numeric|exists:brands,id',
            'year' => 'required|numeric'
        ];

        if (!$this->expectsJson()) { // for web
            $rules['image'] = 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:10240'; // Max 10 MB, example formats
        }

        return $rules;
    }

        /**
     * Custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'brand_id.required' => 'The brand is required.',
            'brand_id.numeric' => 'The brand ID must be a number.',
            'name.unique' => 'The name has already been taken in current brand.',
        ];
    }
}
