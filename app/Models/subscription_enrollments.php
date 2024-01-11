<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subscription_enrollments extends Model
{
    use HasFactory;
    protected $table="subscription_enrollments";
    protected $guarded=['id'];
}
