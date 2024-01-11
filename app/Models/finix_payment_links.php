<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finix_payment_links extends Model
{
    use HasFactory;
    protected $table="finix_payment_links";
    protected $guarded=['id'];
}
