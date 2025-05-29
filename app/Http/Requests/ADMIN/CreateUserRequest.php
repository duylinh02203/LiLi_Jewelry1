<?php

namespace App\Http\Requests\ADMIN;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'username' => 'required|unique:users,username|min:6|max:32|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:32|string',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Tên người dùng là bắt buộc',
            'username.unique' => 'Tên người dùng đã tồn tại',
            'username.min' => 'Tên người dùng phải có ít nhất 6 ký tự',
            'username.max' => 'Tên người dùng không được vượt quá 32 ký tự',
            'username.string' => 'Tên người dùng phải là chuỗi ký tự',
            'email.required' => 'Hãy điền email',
            'email.email' => 'Email phải là một địa chỉ email hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Hãy điền mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu không được vượt quá 32 ký tự',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự',

        ];
    }
}
