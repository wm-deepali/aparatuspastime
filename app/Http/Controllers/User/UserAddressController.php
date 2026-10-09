<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Models\Cart;
use App\Models\CustomerAddress;
use App\Models\State;
use Illuminate\Support\Facades\DB;

class UserAddressController extends Controller
{
    public function index()
    {
        $customer = auth('customer')->user();

        $addresses = $customer->addresses()
            ->with(['state', 'city'])
            ->orderByDesc('is_default')
            ->orderByDesc('id')
            ->get();

        $states = State::orderBy('name')->get();

        return view('user.addresses', compact('customer', 'addresses', 'states'));
    }

    public function store(AddressRequest $request)
    {
        $customer = auth('customer')->user();
        $data = $request->validated();

        DB::transaction(function () use ($customer, $data, $request) {
            // First address is always the default
            $makeDefault = $request->boolean('is_default') || !$customer->addresses()->exists();

            if ($makeDefault) {
                CustomerAddress::where('customer_id', $customer->id)->update(['is_default' => 0]);
            }

            CustomerAddress::create([
                'customer_id' => $customer->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address_line_1' => $data['address_line_1'],
                'address_line_2' => $data['address_line_2'] ?? null,
                'state_id' => $data['state_id'],
                'city_id' => $data['city_id'],
                'pincode' => $data['pincode'],
                'address_type' => $data['address_type'] ?? 'home',
                'is_default' => $makeDefault ? 1 : 0,
            ]);
        });

        $this->refreshCart($customer->id);

        return response()->json(['success' => true, 'message' => 'New address added successfully!']);
    }

    public function setDefault(CustomerAddress $address)
    {
        abort_unless($address->customer_id === auth('customer')->id(), 403);

        DB::transaction(function () use ($address) {
            CustomerAddress::where('customer_id', $address->customer_id)->update(['is_default' => 0]);
            $address->update(['is_default' => 1]);
        });

        // GST is calculated from the default address
        $this->refreshCart($address->customer_id);

        return response()->json(['success' => true, 'message' => 'Default address updated']);
    }

    public function destroy(CustomerAddress $address)
    {
        abort_unless($address->customer_id === auth('customer')->id(), 403);

        $customerId = $address->customer_id;
        $wasDefault = (bool) $address->is_default;

        DB::transaction(function () use ($address, $customerId, $wasDefault) {
            $address->delete();

            // Deleted the default? Promote the newest remaining address
            if ($wasDefault) {
                CustomerAddress::where('customer_id', $customerId)
                    ->latest('id')
                    ->first()?->update(['is_default' => 1]);
            }
        });

        $this->refreshCart($customerId);

        return response()->json(['success' => true, 'message' => 'Address removed']);
    }

    private function refreshCart(int $customerId): void
    {
        Cart::where('user_id', $customerId)->first()?->recalculateTotals();
    }
}