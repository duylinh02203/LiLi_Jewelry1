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
            'username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('users', 'username')->ignore($id),
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
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Điền tên người dùng.',
            'username.string' => 'Tên người dùng phải là chuỗi ký tự.',
            'username.min' => 'Tên người dùng phải có ít nhất :min ký tự.',
            'username.max' => 'Tên người dùng không được vượt quá :max ký tự.',
            'username.unique' => 'Tên người dùng này đã được sử dụng.',

            'email.required' => 'Điền địa chỉ email.',
            'email.email' => 'Vui lòng nhập một địa chỉ email hợp lệ.',
            'email.max' => 'Địa chỉ email không được vượt quá :max ký tự.',
            'email.unique' => 'Email này đã được sử dụng.',

            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        ];
    }
}
