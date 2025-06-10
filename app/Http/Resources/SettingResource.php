<?php

namespace App\Http\Resources;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $imageType = [Settings::PRIMARY_LOGO, Settings::SECONDARY_LOGO, Settings::FAVICON];

        $value = $this->value;
        if (in_array($this->key, $imageType)) {
            $value = asset($this->value);
        }

        $settings = [];
        if ($request->fullUrl() == url('api/v1/settings')) {
            $settings['key'] = $this->key;
        }

        $settings['value'] = $value;

        return $settings;

    }
}
