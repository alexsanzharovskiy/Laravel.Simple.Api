<?php
/**
 * Created by PhpStorm.
 * User: alexsanzharovskiy
 * Date: 19.05.18
 * Time: 14:53
 * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}