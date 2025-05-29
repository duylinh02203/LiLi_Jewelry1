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
            'image' => 'required|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Điền tên danh mục',
            'name.unique' => 'Danh mục đã tồn tại',
            'name.min' => 'Độ dài tên danh mục từ 6 đến 32 ký tự',
            'name.max' => 'Độ dài tên danh mục từ 6 đến 32 ký tự',
            'name.string' => 'Tên danh mục không hợp lệ',
            'image.nullable' => 'Hình ảnh không hợp lệ',
            'image.required' => 'Hình ảnh không được để trống',
            'image.image' => 'Hình ảnh không hợp lệ',
        ];
    }
}
