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
        $sizes = json_decode($this->input('sizes'), true);
        $isFreeSize = empty($sizes);

        return [
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'listed_price' => 'nullable|numeric',
            'description' => 'required|string',
            'category_id' => 'required|numeric',
            'gender' => 'required|in:male,female,unisex',
            'image' => 'required|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

            // Nếu là freesize thì quantity bắt buộc, ngược lại thì bỏ qua
            'quantity' => $isFreeSize ? 'required|numeric|min:1' : 'nullable',

            'sizes' => 'nullable|string', // sẽ kiểm tra sâu hơn ở `withValidator`
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

            'gender.required' => 'Chọn giới tính.',
            'gender.in' => 'Giới tính chỉ chấp nhận: male (Nam), female (Nữ), hoặc unisex.',

            'image.required' => 'Bạn cần tải lên ít nhất một hình ảnh sản phẩm.',
            'image.array' => 'Hình ảnh sản phẩm phải là một mảng.',
            'image.*.image' => 'Mỗi tệp trong hình ảnh phải là một ảnh hợp lệ.',
            'image.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
            'image.*.max' => 'Kích thước mỗi hình ảnh không được vượt quá :max KB.',

            'quantity.required' => 'Vui lòng nhập số lượng sản phẩm.',
            'quantity.numeric' => 'Số lượng sản phẩm phải là một số.',
            'quantity.min' => 'Số lượng sản phẩm phải lớn hơn hoặc bằng :min.',

            'sizes.string' => 'Dữ liệu kích thước phải là chuỗi JSON.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $sizes = json_decode($this->input('sizes'), true);
            if (!empty($sizes)) {
                foreach ($sizes as $index => $size) {
                    if (!isset($size['size']) || !isset($size['quantity']) || !is_numeric($size['quantity']) || $size['quantity'] < 1) {
                        $validator->errors()->add('sizes', 'Size hoặc số lượng không hợp lệ ở dòng ' . ($index + 1));
                    }
                }
            }
        });
    }
}
