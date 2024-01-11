<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_ways extends Model
{
    use HasFactory;
    protected $table="payment_ways";
    protected $guarded=['id'];
}
