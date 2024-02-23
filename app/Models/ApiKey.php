<?php

namespace App\Models;

use Schema;
use Cache;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{

    use HasFactory;
    protected $table="api_keys";
    protected $guarded=['id'];
    public function apiUser(){
        return $this->belongsTo(ApiUser::class,'api_user');
    }
}
