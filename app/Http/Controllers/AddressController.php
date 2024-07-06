<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class AddressController extends Controller
{
    /**
     * store a product
     */
    public function store(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'street' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zipcode' => 'required|string',
                'country' => 'required|string',
            ]);
            $product = Address::create([
                'user_id' => $request->user()->id,
                'street' => $request->street,
                'city' => $request->city,
                'state' => $request->state,
                'zipcode' => $request->zipcode,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Address created successfully',
                'data' => $product,
            ]);
        } catch (ValidationException $e) {
            // Handle the failed validation...
            return response()->json($e->errors(), 422);
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
