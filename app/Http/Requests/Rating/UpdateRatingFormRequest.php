<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRatingFormRequest extends FormRequest
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
            'product_id' => 'required|integer|exists:products,id',
            'rating'    => 'required|numeric|min:1|max:5',
            'comment'   => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Thiếu thông tin sản phẩm.',
            'product_id.integer'  => 'ID sản phẩm không hợp lệ.',
            'product_id.exists'   => 'Sản phẩm không tồn tại.',

            'rating.required' => 'Vui lòng nhập sao đánh giá.',
            'rating.numeric'  => 'Số sao đánh giá phải là số.',
            'rating.min'      => 'Số sao tối thiểu là 1.',
            'rating.max'      => 'Số sao tối đa là 5.',

            'comment.required' => 'Vui lòng nhập nhận xét.',
            'comment.string'   => 'Nhận xét phải là chuỗi văn bản.',
            'comment.max'      => 'Nhận xét không được vượt quá 1000 ký tự.',
        ];
    }
}
