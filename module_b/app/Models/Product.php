<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "french_name",
        "description",
        "french_description",
        "brand_name",
        "origin_country",
        "gross_weight",
        "net_weight",
        "weight_unit",
    ];
    protected $primaryKey = 'GTIN';

    public $incrementing = false;
    protected $keyType = 'integer';

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
