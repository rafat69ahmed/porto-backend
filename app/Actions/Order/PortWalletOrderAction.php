<?php

namespace App\Actions\Order;

use App\DataTransferObjects\InvoiceCreateData;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PortWalletOrderAction
{
    /**
     * @param InvoiceCreateData $data
     * @return array
     * @throws ConnectionException
     */
    public function createInvoice(InvoiceCreateData $data): array
    {
        return Http::withToken(config('portwallet.credentials.token'))
            ->post(
                config('portwallet.endpoints.create_invoice'),
                $data->toArray(),
            )
            ->json();
    }
}
