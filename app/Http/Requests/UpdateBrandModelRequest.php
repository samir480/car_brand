<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateBrandModelRequest extends FormRequest
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
            'name' => 'required|max:255|unique:brand_models,name,' . $this->route('brand_model')->id . 'id,brand_id,' . $this->route('brand_model')->brand_id,
            'brand_id' => 'required|numeric',
            'year' => 'required|numeric',
            'image' => 'nullable',
            File::image()->min('1kb')->max('10mb'),
        ];
    }
}
