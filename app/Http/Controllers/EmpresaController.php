<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function create(){
        return view('empresa.create');
    }
    public function listar(){
        return view('empresa.listar');
    }
}
