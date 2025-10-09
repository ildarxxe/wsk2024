<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "companyName" => $this->name,
            "companyAddress" => $this->address,
            "companyTelephone" => $this->phone_number,
            "companyEmail" => $this->email,
            "owner" => [
                "name" => $this->owner_name,
                "mobileNumber" => $this->owner_number,
                "email" => $this->owner_email,
            ],
            "contact" => [
                "name" => $this->contact_name,
                "mobileNumber" => $this->contact_number,
                "email" => $this->contact_email,
            ],
        ];
    }
}
