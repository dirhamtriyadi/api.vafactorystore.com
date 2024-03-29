<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
            // return parent::toArray($request);
            return [
                'id' => $this->id,
                'name' => $this->name,
                'user_id' => $this->user_id,
                'user' => new UserResource($this->whenLoaded('user')),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
    }
}
