<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'code'        => 'required|min:3|max:255|unique:products,code',
            'name'        => 'required|min:3|max:255',
            'price'       => 'required|numeric|min:1',
            'count'       => 'required|numeric|min:0',
            'description' => 'required|min:5|max:255',
            'category_id' => 'required',
        ];

        if ($this->route()->named('products.update')) {
            $rules['code'] .= ',' . $this->route()->parameter('product')->id;;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'min'      => 'Поле должно содержать минимум :min символов',
            'max'      => 'Поле должно содержать максимум :max символов',
            'price'    => 'Поле должео быть числом и не равняться нулю',
            'count'    => 'Поле должео быть числом и быть не меньше нуля',
            'unique'   => 'Поле обязательно должно быть оригинальным',
            'required' => 'Поле обязательно для ввода',
        ];
    }
}
