<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class fileController extends Controller
{
    public static function createFileString($filePath){
        return file_get_contents($filePath);
    }
}
