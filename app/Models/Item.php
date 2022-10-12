<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public $table = "item";
    public $timestamps = false;
    public $primaryKey = "item_id";
    public $guarded = [
        "item_id"
    ];
    protected $fillable = [
        "description",
        "cost_price",
        "sell_price",
        "title",
        "imagePath"
    ];
}
