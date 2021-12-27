<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            $this->mergeWhen(auth('api')->user()->isFromStaff(), [
                'email_verified' => !is_null($this->email_verified_at),
                'email_verified_at' => $this->when(
                    !is_null($this->email_verified_at),
                    Carbon::create($this->created_at)->format('Y-m-d H:i:s')
                ),
                'created_at' => Carbon::create($this->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::create($this->updated_at)->format('Y-m-d H:i:s'),
                'role' => [
                    'id' => $this->user_role_id,
                ],
            ]),
        ];
    }
}
