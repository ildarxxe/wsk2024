<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => [
                "en" => $this->name,
                "fr" => $this->name_fr,
            ],
            "description" => [
                "en" => $this->description,
                "fr" => $this->description_fr,
            ],
            "gtin" => $this->GTIN,
            "brand" => $this->brand_name,
            "countryOfOrigin" => $this->country,
            "weight" => [
                "gross" => $this->gross_weight,
                "net" => $this->net_weight,
                "unit" => $this->weight_unit
            ],
            "company" => new CompanyResource($this->company)
        ];
    }
}
