<?php

namespace App\Models;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiUser extends Model
{
    use HasFactory;
    protected $table = 'api_users';
    protected $guarded = ['id'];
    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }
    public function apikeys(){
        return $this->hasMany(ApiKey::class,'api_user');
    }
}
