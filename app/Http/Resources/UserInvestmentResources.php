<?php

namespace App\Http\Resources;

use Carbon\CarbonImmutable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Site;

use App\Http\Resources\InvestmentResources;
use App\Services\FilterService;

class UserInvestmentResources extends JsonResource
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
        $r['investment'] = new InvestmentResources($this->investment);
        $r['end_dates'] = FilterService::dateObj($this->end_date);
        $r['days_left'] = $this->days_left();
        $r['can_withdraw'] = $this->can_withdraw();
        return $r;
    }
}
