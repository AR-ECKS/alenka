<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Maquina;

class MaquinaController extends Controller
{

    public function index()
    {
        return view('admin.maquina.index');
    }

}
