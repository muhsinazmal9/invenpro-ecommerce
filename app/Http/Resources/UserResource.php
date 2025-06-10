<?php

namespace App\Http\Resources;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $users = [
            'id' => $this->id,
            'username' => $this->username,
            'first_name' => $this->fname,
            'last_name' => $this->lname,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'phone' => $this?->phone,
            'gender' => $this?->gender,
            'date_of_birth' => $this?->date_of_birth,
            'image' => asset($this->image ?? getSetting(Settings::DEFAULT_AVATAR)),
            // 'image' => $this->image,
        ];

        if ($request->fullUrl() === url('/api/v1/user/details')) {
            $users['orders'] = OrderResource::collection($this->orders);
            $users['address'] = AddressResource::collection($this->addresses);
        }

        return $users;
    }
}
