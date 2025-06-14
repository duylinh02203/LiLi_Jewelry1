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
            'sizes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Điền tên sản phẩm.',
            'name.max' => 'Tên sản phẩm không được vượt quá :max ký tự.',
            'price.required' => 'Điền giá sản phẩm.',
            'price.numeric' => 'Giá bán phải là một số hợp lệ.',
            'listed_price.numeric' => 'Giá niêm yết phải là một số hợp lệ.',
            'description.required' => 'Điền mô tả sản phẩm.',
            'category_id.required' => 'Chọn danh mục sản phẩm.',
            'category_id.numeric' => 'Danh mục phải là một giá trị số hợp lệ.',
            'gender.required' => 'Chọn giới tính',
            'gender.in' => 'Giới tính là một trong các giá trị: nam (male), nữ (female), hoặc unisex.',
            'image.required' => 'Bạn cần tải lên ít nhất một hình ảnh sản phẩm.',
            'image.array' => 'Hình ảnh sản phẩm phải là một mảng.',
            'image.*.image' => 'Mỗi tệp trong hình ảnh phải là một định dạng ảnh hợp lệ.',
            'image.*.max' => 'Kích thước mỗi hình ảnh không được vượt quá :max KB.',
            'quantity.numeric' => 'Số lượng sản phẩm phải là một số hợp lệ.',
            'quantity.min' => 'Số lượng sản phẩm không được nhỏ hơn :min.',
            'sizes.string' => 'Kích thước sản phẩm phải là một chuỗi.',
            'sizes.nullable' => 'Kích thước sản phẩm không bắt buộc.',
        ];
    }
}
