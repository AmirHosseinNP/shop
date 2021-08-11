<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function create()
    {
        return view('client.register.create');
    }

    public function sendMail(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email']
        ]);

        $user = User::generateOTP($request);

        return redirect(route('client.register.checkOtp', $user));
    }

    public function checkOtp(User $user)
    {
        return view('client.register.checkOtp', compact('user'));
    }

    public function verifyOtp(User $user, Request $request)
    {
        $this->validate($request, [
            'otp' => ['required', 'max:5', 'min:5', 'gte:11111', 'lte:99999']
        ]);

        if (!Hash::check($request->otp, $user->password)) {
            return back()->withErrors(['otp', 'کد وارد شده صحیح نیست']);
        }

        auth()->login($user);

        return redirect(route('client.index'));
    }

    public function logout()
    {
        auth()->logout();

        return redirect(route('client.index'));
    }
}
