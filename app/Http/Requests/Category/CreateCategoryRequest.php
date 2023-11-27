<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'name_category' => 'required|unique:categories,name_category'
        ];
    }

    public function messages(): array
    {
        return [
            'name_category.required' => 'Tên danh mục không được để trống!',
            'name_category.unique' => 'Tên danh mục đã có!',
        ];
    }
}
