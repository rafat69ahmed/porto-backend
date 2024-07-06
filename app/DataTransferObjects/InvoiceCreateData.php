<?php

namespace App\DataTransferObjects;

use App\Models\Product;
use App\Models\User;

final class InvoiceCreateData
{
    public function __construct(
        public readonly string $reference,
        public readonly Product $product,
        public readonly User $customer,
    ) {
    }

    /**
     * @param string $reference
     * @param Product $product
     * @param User $customer
     * @return self
     */
    public static function fromData(
        string $reference,
        Product $product,
        User $customer,
    ): self {
        return new self(
            $reference,
            $product,
            $customer,
        );
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'order' => [
                'amount' => $this->product->price,
                'currency' => $this->product->currency,
                'redirect_url' => config('portwallet.redirect_url'),
                'ipn_url' => config('portwallet.ipn_url'),
                'reference' => $this->reference,
            ],
            'product' => [
                'name' => $this->product->name,
                'description' => $this->product->details,
            ],
            'billing' => [
                'customer' => [
                    'name' => $this->customer->name,
                    'email' => $this->customer->email,
                    'phone' => $this->customer->phone,
                    'address' => [
                        'street' => $this->customer->address['street'],
                        'city' => $this->customer->address['city'],
                        'state' => $this->customer->address['state'],
                        'zipcode' => $this->customer->address['zipcode'],
                        'country' => $this->customer->address['country'],
                    ],
                ],
            ],
        ];
    }
}
