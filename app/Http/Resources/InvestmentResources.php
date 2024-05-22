<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Site;


class InvestmentResources extends JsonResource
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
        $images = [];
        foreach ($this->pictures as $p) {
            array_push($images, url("storage/app/$p"));
        }

        $r['images'] = $images;
        return $r;
    }
}
