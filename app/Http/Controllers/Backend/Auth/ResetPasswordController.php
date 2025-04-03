<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class ResetPasswordController extends Controller
{
    /**
     * Hiển thị form đặt lại mật khẩu
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request, $token)
    {
        return view('backend.auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Xử lý form đặt lại mật khẩu
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function resetPassword(Request $request)
    // {
      
    //     // Kiểm tra token trong bảng users thay vì password_resets
    //     $user = User::where('email', $request->email)
    //                 ->where('remember_token', $request->token)
    //                 ->first();
    
    //     if (!$user) {
    //         return back()->withErrors(['token' => 'Token không hợp lệ hoặc đã hết hạn!']);
    //     }
    
    //     // Cập nhật mật khẩu mới
    //     $user->password = Hash::make($request->password);
    //     $user->remember_token = null; // Xóa token sau khi sử dụng
    //     $user->save();
    
    //     return redirect()->route('auth.admin')->with('success', 'Mật khẩu đã được cập nhật.');
    // }
    public function resetPassword(Request $request)
{
    // Validate dữ liệu đầu vào
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:8|confirmed',
    ]);

    // Cập nhật mật khẩu trực tiếp
    $user = User::where('email', $request->email)->first();
    // $user->remember_token = null; // Xóa token sau khi sử dụng
    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->route('auth.admin')->with('success', 'Mật khẩu đã được cập nhật.');
}

}
