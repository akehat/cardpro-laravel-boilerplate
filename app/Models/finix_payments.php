<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finix_payments extends Model
{
    use HasFactory;
    protected $table="finix_payments";
    protected $guarded=['id'];
}
