<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'name' => $this->name,
            'user' => [
                'id' => $this->user_id,
            ],
            $this->mergeWhen(auth('api')->user()->isFromStaff(), [
                'created_at' => Carbon::create($this->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::create($this->updated_at)->format('Y-m-d H:i:s'),
            ]),
        ];
    }
}
