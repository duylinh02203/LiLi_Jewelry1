<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordUser extends FormRequest
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
            'old_password' => 'required',
            'new_password'=>'required|string|min:6|confirmed',
            'new_password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp',
            'new_password_confirmation.required'=>'Vui lòng xác nhận mật khẩu'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = session('userData');

            if (!Hash::check($this->old_password, $user->password)) {
                $validator->errors()->add('old_password', 'Mật khẩu cũ không chính xác');
            }
        });
    }
}
