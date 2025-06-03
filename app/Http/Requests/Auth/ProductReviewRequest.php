<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ProductReviewRequest extends FormRequest
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
            'rating' => 'required|integer|min:1|max:5',
            'comment' => ['required', function ($attribute, $value, $fail) {
                $wordCount = str_word_count(strip_tags($value));
                if ($wordCount < 10) {
                    $fail('Bình luận phải có ít nhất 10 từ.');
                }
            }],
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => 'Bạn chưa chọn số sao.',
            'rating.integer' => 'Số sao không hợp lệ.',
            'rating.min' => 'Bạn chưa chọn số sao.',
            'comment.required' => 'Bạn cần bình luận.',
        ];
    }
}
