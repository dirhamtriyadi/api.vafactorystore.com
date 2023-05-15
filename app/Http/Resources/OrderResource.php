<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_number' => $this->order_number,
            'orderTransaction' => OrderTransactionResource::collection($this->whenLoaded('orderTransaction')),
            'orderTracking' => OrderTrackingResource::collection($this->whenLoaded('orderTracking')),
            // 'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            // 'customer_id' => $this->customer_id,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            // 'print_type_id' => $this->print_type_id,
            'print_type' => new PrintTypeResource($this->whenLoaded('printType')),
            'qty' => $this->qty,
            'price' => $this->price,
            'total' => $this->total,
            'discount' => $this->discount,
            'subtotal' => $this->subtotal,
            'name' => $this->name,
            'description' => $this->description,
            'order_date' => $this->order_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'orderTransactions' => OrderTransactionResource::collection($this->whenLoaded('orderTransactions'))
        ];
    }
}
