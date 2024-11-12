<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

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
        return [
            'name' => 'required|max:255|unique:brand_models,name,NULL,id,brand_id,'.$this->brand_id,
            'brand_id' => 'required|numeric',
            'year' => 'required|numeric',
            'image' => 'required',
            File::image()
                ->min('1kb')
                ->max('10mb'),
        ];
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
