<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangeUserInforRequest extends FormRequest
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
        $user = session('userData');
        return [
            'name' => 'required|string|min:6|max:255|unique:users,name,' . $user->id,
            'phone' => 'required|string|min:10|max:15|unique:user_infors,phone,' . $user->id . ',user_id',
            'confirmPass'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'name.min' => 'Tên phải có ít nhất 6 ký tự',
            'name.max' => 'Tên không được vượt quá 255 ký tự',
            'name.unique' => 'Tên người dùng đã tồn tại',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 ký tự',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự',
            'phone.unique'=>'Số điện thoại đã tồn tại',
            'confirmPass.required'=>'Điền mật khẩu của bạn',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = session('userData');

            if (!Hash::check($this->confirmPass, $user->password)) {
                $validator->errors()->add('confirmPass', 'Mật khẩu cũ không chính xác');
            }
        });
    }
}
