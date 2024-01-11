<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finix_users extends Model
{
    use HasFactory;
    protected $table="finix_users";
    protected $guarded=['id'];
}
