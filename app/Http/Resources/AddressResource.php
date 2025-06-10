<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'customer_name' => $this->customer_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'street_address' => $this->street_address,
            'apt_or_floor' => $this->apt_or_floor,
            'zip_code' => $this->zip_code,
            'city' => $this->city,
            'country' => $this->country,
            'type' => $this->getAddressType($this->type),
            'coordinate' => $this->coordinate,
        ];
    }

    public function getAddressType(int $type)
    {
        switch ($type) {
            case 1:
                return 'billing';
            case 2:
                return 'shipping';
        }
    }
}
