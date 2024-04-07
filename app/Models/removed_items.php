<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class removed_items extends Model
{
    use HasFactory;
    protected $table="removed_items";
    protected $guarded=['id'];
}
