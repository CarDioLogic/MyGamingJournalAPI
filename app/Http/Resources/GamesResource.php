<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GamesResource extends JsonResource
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
            'id' => (string)$this->id,
            'atributes' => [
                'rawgApiId' => $this->rawgApiId,
                'title' => $this->title,
                'thumbnail' => $this->thumbnail,
                'short_description' => $this->short_description,
                'game_site_url' => $this->game_site_url,
                'game_img_url' => $this->game_img_url,
                'release_date' => $this->release_date,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]
        ];
    }
}
