<?php

namespace App\Http\Requests\ADMIN;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
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
           'first_name' => ['required', 'regex:/^[\pL\s]+$/u'],
            'last_name'  => ['required', 'regex:/^[\p{L}\s]+$/u', 'max:32'],
            'email'      => 'required|email:rfc,dns|max:80',
            'phone'      => ['required', 'regex:/^0\d{9}$/'],
            'comment'    => 'required|string|max:1000',
        ];
    }



    public function messages(): array
    {
        return [
            'first_name.required' => 'Vui lòng nhập tên.',
            'first_name.regex'    => 'Tên chỉ được chứa chữ cái và khoảng trắng.',
            'first_name.max'      => 'Tên không được vượt quá 32 ký tự.',

            'last_name.required' => 'Vui lòng nhập họ.',
            'last_name.regex'    => 'Họ chỉ được chứa chữ cái và khoảng trắng.',
            'last_name.max'      => 'Họ không được vượt quá 32 ký tự.',

            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email'    => 'Địa chỉ email không hợp lệ.',
            'email.max'      => 'Địa chỉ email không được vượt quá 80 ký tự.',

            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex'    => 'Số điện thoại phải bắt đầu bằng số 0 và gồm 10 chữ số.',

            'comment.required' => 'Vui lòng nhập nội dung bình luận.',
            'comment.string'   => 'Nội dung bình luận phải là chuỗi ký tự.',
            'comment.max'      => 'Nội dung bình luận không được vượt quá 1000 ký tự.',
        ];
    }
}
