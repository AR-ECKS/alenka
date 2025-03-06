<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RegistroParaPicarController extends Controller
{

    public function index(Request $request)
    {
        return view('admin.registro_para_picar.index');
    }
}
