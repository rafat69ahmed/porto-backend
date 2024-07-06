<?php

namespace App\Actions\Order;

use App\DataTransferObjects\InvoiceCreateData;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use DateMalformedStringException;
use Illuminate\Support\Arr;

class OrderAction
{
    /**
     * @param int $customerId
     * @param int $productId
     * @return Order
     * @throws DateMalformedStringException
     */
    public function create(int $customerId, int $productId): Order
    {
        $customer = User::with('address')->find($customerId);
        $product = Product::query()->find($productId);
        // $billing = new \stdClass();
        // $billing->customer = $customer;
        // $billing = [
        //     'customer' => $customer
        // ];
        $orderCode = strtoupper(uniqid('POP_', false));

        $response = app(PortWalletOrderAction::class)->createInvoice(
            InvoiceCreateData::fromData($orderCode, $product, $customer)
        );

        /** @var Order $order */
        $order = Order::create([
            'user_id' => $customerId,
            'product_id' => $productId,
            'order_time' => Carbon::now(),
            'order_code' => $orderCode,
            'amount' => $product->price,
            'currency' => $product->currency,
            'status_idx' => OrderStatusEnum::PENDING,
            'invoice_id' => Arr::get($response, 'data.invoice_id'),
            'redirect_url' => Arr::get($response, 'data.action.url'),
        ]);
        $response = app(PortWalletOrderAction::class)->createInvoice(
            InvoiceCreateData::fromData($orderCode, $product, $customer)
        );
        return $order;
    }
}
