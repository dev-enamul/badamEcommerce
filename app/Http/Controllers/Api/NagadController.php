<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NagadController extends Controller
{
    public function createPayement(Request $request)
    {
        return $request->all();
    }
}
