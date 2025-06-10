<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $banner= [
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            // 'position' => $this->position,
            'type' => $this->type,
            'image' => $this->image ? asset($this->image) : null,
            'link' => $this->link,
        ];
        if($request->type=='popup'){
           $banner['countdown_start'] = $this->countdown_start;
           $banner['countdown_end'] = $this->countdown_end;
        }

        return $banner;
    }
}
