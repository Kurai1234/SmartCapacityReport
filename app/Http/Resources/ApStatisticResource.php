<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AccessPointResource;
class ApStatisticResource extends JsonResource
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
            'connected_sms'=>$this->connected_sms,
            'dl_capacity_throughput'=>$this->dl_capacity_throughput,
            'ul_throughput'=>$this->ul_throughput,
            'dl_throughput'=>$this->dl_throughput,
            'dl_retransmit_pcts'=>$this->dl_retransmit_pcts,
            'accesspoint'=> AccessPointResource::make($this->whenLoaded('accesspoint'))

        ];
    }
}
