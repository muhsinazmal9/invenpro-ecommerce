<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CmsPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $cms = [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,

        ];

        if ($request->fullUrl() == url('api/v1/pages').'/'.$this->slug) {
            $cms['content'] = $this->content;
            $cms['meta_title'] = $this->meta_title;
            $cms['meta_description'] = $this->meta_description;

        }

        return $cms;

    }
}
