<?php

namespace App\Http\Resources;

use App\Enums\OrderStatuses;
use App\Enums\PaymentGateways;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'orderable_title' => $this->orderable->title,
            'total_amount' => $this->total_amount,
            'description' => $this->description,
            'paid_at' => Verta::instance($this->paid_at)->format('d F Y'),
            'status' => OrderStatuses::label($this->order_status),
            'created_at' => Verta::instance($this->created_at)->format('d F Y'),
        ];
    }
}
