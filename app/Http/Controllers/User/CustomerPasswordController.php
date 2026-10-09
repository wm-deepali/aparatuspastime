<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\Email\EmailDispatcher;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class CustomerPasswordController extends Controller
{
    protected function broker()
    {
        return Password::broker('customers');
    }

    public function forgotForm()
    {
        return view('user.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $customer = Customer::where('email', $request->email)->first();

        if ($customer) {
            $token = $this->broker()->createToken($customer);

            $resetUrl = route('reset-password', [
                'token' => $token,
                'email' => $customer->email,
            ]);

            EmailDispatcher::send(
                'password-reset',
                $customer->email,
                [
                    '{customer_name}' => $customer->name,
                    '{reset_url}' => $resetUrl,
                ],
                $customer->name
            );
        }

        // Same response whether or not the email exists (no account enumeration)
        return response()->json([
            'status' => true,
            'message' => 'If this email is registered, a password reset link has been sent.',
        ]);
    }

    public function resetForm(Request $request, string $token)
    {
        return view('user.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate(
            [
                'token' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8', 'confirmed'],
            ],
            ['password.confirmed' => 'Password and confirm password do not match.']
        );

        $status = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($customer, $password) {
                $customer->forceFill(['password' => $password])->save();
                event(new PasswordReset($customer));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully. Please sign in.',
                'redirect' => route('user.login'),
            ]);
        }

        return response()->json([
            'message' => 'This reset link is invalid or has expired. Please request a new one.',
            'errors' => ['email' => ['This reset link is invalid or has expired.']],
        ], 422);
    }
}