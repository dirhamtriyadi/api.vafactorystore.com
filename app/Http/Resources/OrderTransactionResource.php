<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            // 'order_id' => $this->order_id,
            // 'order' => new OrderResource($this->whenLoaded('order')),
            'order' => $this->order,
            // 'payment_method_id' => $this->payment_method_id,
            // 'payment_method' => new PaymentMethodResource($this->whenLoaded('paymentMethod')),
            'payment_method' => $this->paymentMethod,
            'amount' => $this->amount,
            'date' => $this->date,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
