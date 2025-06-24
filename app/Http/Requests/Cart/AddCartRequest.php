<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class AddCartRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required'       => 'Vui lòng chọn sản phẩm.',
            'product_id.exists'         => 'Sản phẩm không tồn tại.',
            'quantity.required'         => 'Vui lòng nhập số lượng sản phẩm.',
            'quantity.integer'          => 'Số lượng phải là số nguyên.',
            'quantity.min'              => 'Số lượng phải lớn hơn hoặc bằng 1.',
        ];
    }
}
