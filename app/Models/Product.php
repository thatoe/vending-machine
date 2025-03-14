<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'quantity_available'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
