<?php

namespace App\Http\Requests\ADMIN;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'listed_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'gender' => 'required|in:male,female,unisex',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sizes' => 'nullable|string',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Điền tên sản phẩm',
            'name.max' => 'Tên sản phẩm không được vượt quá :max ký tự',
            'description.required' => 'Điền mô tả sản phẩm',
            'price.required' => 'Điền giá sản phẩm',
            'price.numeric' => 'Giá sản phẩm không hợp lệ',
            'image.array' => 'Hình ảnh sản phẩm phải là một mảng',
            'image.*.image' => 'Hình ảnh không hợp lệ',
            'image.*.max' => 'Kích thước mỗi hình ảnh không được vượt quá :max KB',
            'sizes.string' => 'Kích thước sản phẩm phải là một chuỗi',
        ];
    }
}
