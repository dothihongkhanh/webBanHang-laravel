<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateDetailProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'details.*.size' => 'required|numeric|gt:0',
            'details.*.color' => 'required',
            'details.*.inventory_number' => 'required|numeric|gt:0',

        ];
    }

    public function messages(): array
    {
        return [
            'details.*.size.required' => 'Kích thước không được để trống!',
            'details.*.size.gt' => 'Kích thước phải lớn hơn 0!',
            'details.*.color.required' => 'Màu sắc không được để trống!',
            'details.*.inventory_number.required' => 'Số lượng không được để trống!',
            'details.*.inventory_number.gt' => 'Số lượng phải lớn hơn 0!',
        ];
    }
}
