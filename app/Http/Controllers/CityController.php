<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Lista de registros',
            'payload' => DB::table('cities')->select('id', 'name', 'code')->orderBy('order')->get(),
        ]);
    }
}
