<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class IpnHandlerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function ipnStatus(Request $request)
    {
        $order = Order::where('invoice_id', $request->input('invoice'))
            ->where('order_code', $request->input('reference'))
            ->first();

        $order?->update(['status_idx' => $this->orderStatus($request->input('status'))]);

        return response()->json();
    }

    private function orderStatus(string $paymentStatus): OrderStatusEnum
    {
        return match ($paymentStatus) {
            'ACCEPTED' => OrderStatusEnum::PAID,
            'REJECTED' => OrderStatusEnum::PAYMENT_FAILED,
        };
    }
}
