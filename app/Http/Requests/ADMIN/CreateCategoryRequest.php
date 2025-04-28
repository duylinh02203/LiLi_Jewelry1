<?php

namespace App\Http\Requests\ADMIN;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'name' => 'required|unique:categories,name|min:6|max:32|string',
            'description' => 'required|min:10|max:256|string'
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.unique' => 'Name is unique',
            'name.min' => 'Name must be at least 6 characters',
            'name.max' => 'Name must be at most 32 characters',
            'name.string' => 'Name must be a string',
            'description.required' => 'Description is required',
            'description.min' => 'Description must be at least 10 characters',
            'description.max' => 'Description must be at most 256 characters',
            'description.string' => 'Description must be a string'
        ];
    }
}
