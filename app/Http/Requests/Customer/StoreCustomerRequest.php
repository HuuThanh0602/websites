<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the customer is authorized to make this request.
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
            'email' => 'required|string|email|unique:customers|max:191',
            'name' => 'required|string|regex:/^[\p{L} ]+$/u|max:255', 
            'phone' => 'required|unique:customers|regex:/^[0-9]{10}$/', 
            'customer_catalogue_id' => 'gt:0',
            'password' => [
                'required',
                'string',
                'min:8',       
                'max:16',      
                'regex:/[a-z]/', 
                'regex:/[A-Z]/', 
                'regex:/[0-9]/', 
                'regex:/[@$!%*?&]/' 
            ],
            're_password' => 'required|string|same:password',
        ];
    }
    

    public function messages(): array
    {
        return [
            'email.required' => 'Bạn chưa nhập vào email.',
            'email.email' => 'Email chưa đúng định dạng. Ví dụ: abc@gmail.com',
            'email.unique' => 'Email đã tồn tại. Hãy chọn email khác',
            'email.string' => 'Email phải là dạng ký tự',
            'email.max' => 'Độ dài email tối đa 191 ký tự',
            
            'name.required' => 'Bạn chưa nhập Họ Tên',
            'name.string' => 'Họ Tên phải là dạng ký tự',
            'name.regex' => 'Họ Tên chỉ được chứa chữ cái và khoảng trắng',
            'name.max' => 'Họ Tên không được dài quá 255 ký tự',
    
            'phone.required' => 'Bạn chưa nhập vào số điện thoại.',
            'phone.regex' => 'Số điện thoại phải có đúng 10 chữ số.',
            'phone.unique' => 'Số điện thoại đã tồn tại. Hãy chọn số điện thoại khác.',
    
            'customer_catalogue_id.gt' => 'Bạn chưa chọn loại cộng tác viên',
    
            'password.required' => 'Bạn chưa nhập vào mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.max' => 'Mật khẩu không được dài quá 16 ký tự.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt.',
    
            're_password.required' => 'Bạn phải nhập vào ô Nhập lại mật khẩu.',
            're_password.same' => 'Mật khẩu không khớp.',
        ];
    }
    
}
