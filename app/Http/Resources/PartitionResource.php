<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PartitionResource extends JsonResource
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
            'description' => $this->description,
            'balance' => number_format($this->balance, 2, '.', ''),
            'goal' => !is_null($this->goal) ? number_format($this->goal, 2, '.', '') : null,
            'due_date' => !is_null($this->due_date) ? Carbon::create($this->due_date)->format('Y-m-d H:i:s') : null,
            'created_at' => Carbon::create($this->created_at)->format('Y-m-d H:i:s'),
            'account' => [
                'id' => $this->account_id,
            ],
        ];
    }
}
