<?php

namespace App\Http\Resources;

use App\Enums\BankServiceRequestStatuses;
use App\Models\BankServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin BankServiceRequest */
class BankServiceRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'bank_service' => BankServiceResource::make($this->bank_service),
            'request_title' => $this->bank_service_price_title,
            'request_amount' => $this->bank_service_price_amount,
            'additional_data' => $this->additional_data,
            'status' => BankServiceRequestStatuses::label($this->status)
        ];
    }
}
