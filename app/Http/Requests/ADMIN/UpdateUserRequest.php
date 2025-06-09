<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('users', 'name')->ignore($id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'password' => [
                'nullable',
                'string',
                'min:6',
            ],
            'phone' => [
                'required',
                'string',
                'min:10',
                'max:15',
                Rule::unique('user_infors', 'phone')->ignore($id, 'user_id'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Điền tên người dùng.',
            'name.string' => 'Tên người dùng phải là chuỗi ký tự.',
            'name.min' => 'Tên người dùng phải có ít nhất :min ký tự.',
            'name.max' => 'Tên người dùng không được vượt quá :max ký tự.',
            'name.unique' => 'Tên người dùng này đã được sử dụng.',

            'email.required' => 'Điền địa chỉ email.',
            'email.email' => 'Vui lòng nhập một địa chỉ email hợp lệ.',
            'email.max' => 'Địa chỉ email không được vượt quá :max ký tự.',
            'email.unique' => 'Email này đã được sử dụng.',

            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 ký tự',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự',
            'phone.unique' => 'Số điện thoại đã tồn tại',
        ];
    }
}
