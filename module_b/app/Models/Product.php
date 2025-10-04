<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'GTIN';

    public $incrementing = false;
    protected $keyType = 'integer';

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
