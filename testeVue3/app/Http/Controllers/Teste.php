<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Teste extends Controller
{
    public function teste()
    {
        return response()->json('ola');
    }
}
