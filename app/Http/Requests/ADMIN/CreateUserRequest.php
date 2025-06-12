<?php

namespace App\Http\Requests\ADMIN;

use Illuminate\Validation\Rule;
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
        $id = $this->route('id');
        return [
            'name' => 'required|unique:users,name|min:6|max:32|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:32|string',
            'confirm_password' => 'required|same:password',
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
            'name.required' => 'Tên người dùng là bắt buộc',
            'name.unique' => 'Tên người dùng đã tồn tại',
            'name.min' => 'Tên người dùng phải có ít nhất 6 ký tự',
            'name.max' => 'Tên người dùng không được vượt quá 32 ký tự',
            'name.string' => 'Tên người dùng phải là chuỗi ký tự',
            'email.required' => 'Hãy điền email',
            'email.email' => 'Email phải là một địa chỉ email hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Hãy điền mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu không được vượt quá 32 ký tự',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự',
            'confirm_password.required' => 'Hãy điền mật khẩu',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp với mật khẩu',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 ký tự',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự',
            'phone.unique'=>'Số điện thoại đã tồn tại',
        ];
    }
}
