<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;


class PreSalidaMolinoController extends Controller
{

    public function index($id_proceso)
    {
        return view('admin.pre_salida_molino', compact('id_proceso'));
    }

}
