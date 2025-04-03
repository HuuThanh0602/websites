<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerCatalogueRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
{
    return [
        'name' => 'required|string',
        'quantity_condition' => 'required|numeric',
        'money_condition' => 'required|numeric',
        'duration_condition' => 'required|numeric',
        'percent' => 'required|numeric',
    ];
}


public function messages(): array
{
    return [
        'name.required' => 'Bạn chưa nhập Nhóm thành viên.',
        'name.string' => 'Nhóm thành viên phải là dạng ký tự.',

        'quantity_condition.required' => 'Bạn chưa nhập số lượng điều kiện.',
        'quantity_condition.numeric' => 'Số lượng điều kiện phải là số.',

        'money_condition.required' => 'Bạn chưa nhập giá trị điều kiện.',
        'money_condition.numeric' => 'Giá trị điều kiện phải là số.',

        'duration_condition.required' => 'Bạn chưa nhập thời gian điều kiện.',
        'duration_condition.numeric' => 'Thời gian điều kiện phải là số.',

        'percent.required' => 'Bạn chưa nhập phần trăm.',
        'percent.numeric' => 'Phần trăm phải là số.',
    ];
}

}
