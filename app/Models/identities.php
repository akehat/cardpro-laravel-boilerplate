<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class identities extends Model
{
    use HasFactory;
    protected $table="identities";
    protected $guarded=['id'];
}
