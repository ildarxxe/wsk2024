<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = "GTIN";
    public $incrementing = false;

    protected $fillable = [
        "GTIN",
        "company_id",
        "name",
        "name_fr",
        "description",
        "description_fr",
        "brand_name",
        "image_url",
        "country",
        "gross_weight",
        "net_weight",
        "weight_unit",
        "is_hidden",
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            $model->company_id = random_int(1,6);
        });
    }
}
