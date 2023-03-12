<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'date' => $this->date,
            'transaction_number' => $this->transaction_number,
            'customers_id' => $this->customers_id,
            'users_id' => $this->users_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'transactionDetails' => TransactionDetailResource::collection($this->whenLoaded('transactionDetails'))
        ];
    }
}
