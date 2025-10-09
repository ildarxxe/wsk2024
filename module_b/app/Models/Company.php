<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
        "address",
        "phone_number",
        "email",
        "owner_name",
        "owner_number",
        "owner_email",
        "contact_name",
        "contact_number",
        "contact_email",
        "is_deactivated",
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }
}
