<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductFormRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:in_stock,out_stock',
            'unit' => 'required|string|max:50',
            'featured' => 'nullable|bool',
            'benefits' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Vui lòng nhập tên sản phẩm.',
            'slug.required'        => 'Vui lòng nhập slug.',
            'slug.unique'          => 'Slug đã tồn tại. Vui lòng chọn slug khác.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists'   => 'Danh mục không hợp lệ.',
            'price.required'       => 'Vui lòng nhập giá sản phẩm.',
            'price.numeric'        => 'Giá sản phẩm phải là số.',
            'price.min'            => 'Giá phải lớn hơn hoặc bằng 0.',
            'stock.required'       => 'Vui lòng nhập số lượng tồn kho.',
            'stock.integer'        => 'Tồn kho phải là số nguyên.',
            'stock.min'            => 'Tồn kho không thể nhỏ hơn 0.',
            'status.required'      => 'Vui lòng chọn trạng thái.',
            'status.in'            => 'Trạng thái không hợp lệ.',
            'unit.required'        => 'Vui lòng nhập đơn vị.',
        ];
    }
}
