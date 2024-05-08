<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_payment'=>$this->id,
            'family_account_id '=>$this->family_account->id ,
            'user_name' => $this->family_account->user->name,
            'monthly_payment'=>$this->monthly_payment,
            'daily_price'=>$this->daily_price->price,
            'month_id'=> $this->daily_price->month->id,
            'month' => $this->daily_price->month->name,
            'payment_status'=>$this->payment_status,
            'payment_date'=>$this->payment_date,
        ];
    }
}
