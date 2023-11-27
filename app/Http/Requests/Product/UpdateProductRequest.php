<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name_product' => 'required',
            'image_upload' => 'image|mimes:png,jpg,PNG,jpec',
            'price' => 'required|numeric|gt:0',
            'description' => 'required',
            'details.*.size' => 'required|numeric|gt:0',
            'details.*.color' => 'required',
            'details.*.inventory_number' => 'required|numeric|gt:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name_product.required' => 'Tên sản phẩm không được để trống!',
            'image_upload.image' => 'Định dạng ảnh phải là png,jpg,PNG,jpec!',
            'price.required' => 'Giá sản phẩm không được để trống!',
            'price.gt' => 'Giá sản phẩm phải lớn hơn 0!',
            'description.required' => 'Mô tả sản phẩm không được để trống!',
            'details.*.size.required' => 'Kích thước không được để trống!',
            'details.*.size.gt' => 'Kích thước phải lớn hơn 0!',
            'details.*.color.required' => 'Màu sắc không được để trống!',
            'details.*.inventory_number.required' => 'Số lượng không được để trống!',
            'details.*.inventory_number.gt' => 'Số lượng phải lớn hơn 0!',
        ];
    }
}
