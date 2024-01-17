<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class email_service extends Model
{
    use HasFactory;
    protected $table= "email_service";
    protected $guarded=["id"];
}
