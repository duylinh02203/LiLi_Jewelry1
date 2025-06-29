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
        $sizes = json_decode($this->input('sizes'), true);
        $isFreeSize = empty($sizes); // true nếu không có size nào

        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'listed_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'gender' => 'required|in:male,female,unisex',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sizes' => 'nullable|string', // sẽ check sâu hơn ở withValidator

            'quantity' => $isFreeSize ? 'required|integer|min:1' : 'nullable', // chỉ bắt buộc nếu là freesize
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Điền tên sản phẩm.',
            'name.max' => 'Tên sản phẩm không được vượt quá :max ký tự.',

            'description.required' => 'Điền mô tả sản phẩm.',

            'price.required' => 'Điền giá sản phẩm.',
            'price.numeric' => 'Giá sản phẩm không hợp lệ.',
            'listed_price.numeric' => 'Giá niêm yết không hợp lệ.',

            'category_id.required' => 'Chọn danh mục.',
            'category_id.exists' => 'Danh mục không hợp lệ.',

            'gender.required' => 'Chọn giới tính.',
            'gender.in' => 'Giới tính chỉ chấp nhận: male (Nam), female (Nữ), hoặc unisex.',

            'image.*.image' => 'Mỗi tệp phải là ảnh hợp lệ.',
            'image.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
            'image.*.max' => 'Mỗi hình ảnh không vượt quá :max KB.',

            'quantity.required' => 'Vui lòng nhập số lượng nếu là sản phẩm freesize.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng :min.',

            'sizes.string' => 'Kích thước sản phẩm phải là chuỗi JSON hợp lệ.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $sizes = json_decode($this->input('sizes'), true);

            if (!empty($sizes)) {
                foreach ($sizes as $index => $item) {
                    $size = $item['size'] ?? null;
                    $quantity = $item['quantity'] ?? null;

                    if (!$size || trim($size) === '') {
                        $validator->errors()->add("sizes", "Size ở dòng " . ($index + 1) . " không được để trống.");
                    }

                    if (!is_numeric($quantity) || intval($quantity) < 0) {
                        $validator->errors()->add("sizes", "Số lượng ở dòng " . ($index + 1) . " phải là số ≥ 0.");
                    }
                }
            }
        });
    }
}
