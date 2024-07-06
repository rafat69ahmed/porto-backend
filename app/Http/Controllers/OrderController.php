<?php

namespace App\Http\Controllers;

use App\Actions\Order\OrderAction;
use App\Models\Order;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * list of orders
     */
    public function index()
    {
        try {
            $orders = Order::paginate(10);
            return response()->json([
                'status' => 'success',
                'message' => 'fetched order list successfully',
                'data' => $orders,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id'),
            ],
            'product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id'),
            ],
        ]);
        try {

            $order = app(OrderAction::class)
                ->create($request->input('user_id'), $request->input('product_id'));
            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'data' => $order,
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
