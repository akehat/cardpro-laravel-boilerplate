<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pci_forms extends Model
{
    use HasFactory;
    protected $table="pci_forms";
    protected $guarded=['id'];

}
