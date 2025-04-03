<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Customer;

class AuthRegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email:rfc,dns',
                'string',
                'max:191',
                function ($attribute, $value, $fail) {
                    $existingCustomer = Customer::where('email', $value)->first();
                    if ($existingCustomer && $existingCustomer->publish != 1) {
                        $fail('Email đã tồn tại. Hãy chọn email khác.');
                    }
                },
            ],
            'phone' => [
                'required',
                'regex:/^(0[1-9][0-9]{8})$/',
                function ($attribute, $value, $fail) {
                    $existingCustomer = Customer::where('phone', $value)->first();
                    if ($existingCustomer && $existingCustomer->publish != 1) {
                        $fail('Số điện thoại đã tồn tại. Hãy chọn số điện thoại khác.');
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:16',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/',
            ],
            're_password' => 'required|string|same:password',
            'referral_by' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!empty($value)) {
                        $referrer = Customer::where('phone', $value)->first();
                        if (!$referrer) {
                            $fail('Mã giới thiệu không hợp lệ.');
                        }
                    }
                },
            ],
            'min_orders' => 'required|integer|min:1',
            'monthly_spending' => 'required|integer|min:0',
            'about_me' => 'required|string|max:500',
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.string' => 'Email phải là một chuỗi ký tự.',
            'email.max' => 'Email không được vượt quá 191 ký tự.',

            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập đúng định dạng.',

            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.string' => 'Mật khẩu phải là một chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 16 ký tự.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ cái viết hoa, một chữ cái viết thường, một số và một ký tự đặc biệt.',

            're_password.required' => 'Vui lòng nhập lại mật khẩu.',
            're_password.string' => 'Mật khẩu xác nhận phải là một chuỗi ký tự.',
            're_password.same' => 'Mật khẩu xác nhận không khớp với mật khẩu.',

            'min_orders.required' => 'Vui lòng nhập số đơn hàng tối thiểu/tháng.',
            'min_orders.integer' => 'Số đơn hàng phải là số nguyên.',
            'min_orders.min' => 'Số đơn hàng tối thiểu phải từ 1 trở lên.',

            'monthly_spending.required' => 'Vui lòng nhập tổng chi tiêu/tháng.',
            'monthly_spending.integer' => 'Tổng chi tiêu phải là số nguyên.',
            'monthly_spending.min' => 'Tổng chi tiêu không thể nhỏ hơn 0.',

            'about_me.required' => 'Vui lòng nhập giới thiệu bản thân.',
            'about_me.string' => 'Giới thiệu bản thân phải là một chuỗi ký tự.',
            'about_me.max' => 'Giới thiệu bản thân không được vượt quá 500 ký tự.',
        ];
    }
}
