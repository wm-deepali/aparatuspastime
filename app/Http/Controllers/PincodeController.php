<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pincode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PincodeController extends Controller
{
    public function check(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'pincode' => 'required|digits:6',
        ]);

        $row = Pincode::with(['state:id,name', 'city:id,name'])
            ->where('pincode', $validated['pincode'])
            ->first();

        if (!$row) {
            return response()->json([
                'status' => false,
                'message' => 'This pincode was not found. Please check and try again.',
            ]);
        }

        if (!$row->is_serviceable) {
            return response()->json([
                'status' => false,
                'message' => 'Sorry, we do not deliver to this pincode yet.',
            ]);
        }

        return response()->json([
            'status' => true,
            'pincode' => $row->pincode,
            'district' => $row->city?->name ?? $row->district,
            'state' => $row->state?->name,
        ]);
    }
}