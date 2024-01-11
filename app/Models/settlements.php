<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class settlements extends Model
{
    use HasFactory;
    protected $table="settlements";
    protected $guarded=['id'];
}
