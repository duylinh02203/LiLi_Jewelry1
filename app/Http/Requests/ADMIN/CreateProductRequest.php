<?php

namespace App\Http\Requests\ADMIN;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'listed_price' => 'numeric',
            'description' => 'required',
            'category_id' => 'required|numeric',
            'gender' => 'required|in:male,female,unisex',
            'image' => 'required|array',
            'image.*' => 'image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.max' => 'Name is too long',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be number',
            'listed_price.numeric' => 'Listed price must be number',
            'description.required' => 'Description is required',
            'category_id.required' => 'Category is required',
            'category_id.numeric' => 'Category must be number',
            'gender.required' => 'Gender is required',
            'gender.in' => 'Gender must be male, female, unisex',
            'image.required' => 'Image is required',
            'image.image' => 'Image must be image',
            'image.max' => 'Image is too long',
            'image.*.image' => 'Image must be image',
            'image.*.max' => 'Image is too long',
        ];
    }
}
