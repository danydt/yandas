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
            'id' => $this->internal_code,
            'code' => $this->external_code,
            'created_at' => $this->created_at->locale('fr_FR')->isoFormat('LL'),
            'items_count' => $this->detail_count,
            'order_status' => $this->proforma_amount > 0 ? ($this->paid_amount == 0 ? 'En attente de paiement' : 'En attente de solde') : 'En attente',
            'items' => $request->whenHas('include-items', function () {

                return OrderItemResource::collection($this->details);
            })
        ];
    }
}
