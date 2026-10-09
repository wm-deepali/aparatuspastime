<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function profile()
    {
        $customer = auth('customer')->user();

        // Google signups get a placeholder number (time()), so only show real mobile numbers
        $validMobile = fn($m) => preg_match('/^[6-9]\d{9}$/', (string) $m) ? $m : '';

        return view('user.profile', [
            'customer' => $customer,
            'mobile' => $validMobile($customer->mobile),
            'alternateMobile' => $validMobile($customer->alternate_mobile),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $customer = auth('customer')->user();

        $data = $request->validate(
            [
                'name' => ['required', 'max:100', 'regex:/^[A-Za-z\s]+$/'],
                'email' => ['required', 'email', Rule::unique('customers', 'email')->ignore($customer->id)],
                'mobile' => ['required', 'regex:/^[6-9]\d{9}$/', Rule::unique('customers', 'mobile')->ignore($customer->id)],
                'alternate_mobile' => ['nullable', 'regex:/^[6-9]\d{9}$/'],
            ],
            [
                'name.regex' => 'Name should contain only letters.',
                'mobile.regex' => 'Enter a valid Indian mobile number.',
                'alternate_mobile.regex' => 'Enter a valid alternate mobile number.',
            ]
        );

        $customer->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Profile information saved!',
        ]);
    }

    public function passwordForm()
    {
        return view('user.password', ['customer' => auth('customer')->user()]);
    }

    public function updatePassword(Request $request)
    {
        $customer = auth('customer')->user();

        $request->validate(
            [
                'current_password' => ['required', 'current_password:customer'],
                'password' => ['required', 'min:8', 'confirmed', 'different:current_password'],
            ],
            [
                'current_password.current_password' => 'Current password is incorrect.',
                'password.confirmed' => 'New password and confirm password do not match.',
                'password.different' => 'New password must be different from the current one.',
            ]
        );

        // Password is hashed by the Customer model, same as register()
        $customer->forceFill(['password' => $request->password])->save();

        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully!',
        ]);
    }
}