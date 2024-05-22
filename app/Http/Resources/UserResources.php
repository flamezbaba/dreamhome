<?php

namespace App\Http\Resources;

use Carbon\CarbonImmutable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Site;

use App\Services\FilterService;

class UserResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $r = parent::toArray($request);
        $r['user_info'] = $this->info;  
        $r['front_image'] = $this->front_image();
        $r['wallet_balance'] = $this->wallet_balance();
        $r['total_investment'] = $this->total_investment();
        $r['total_withdrawal'] = $this->total_withdrawal();
        $r['referral'] = $this->referral();
        $r['bank'] = $this->bank;
        $r['crypto'] = $this->crypto;
        return $r;
    }
}
