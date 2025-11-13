<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function create(){
        return view('cliente.create');
    }
    public function listar(){
        return view('cliente.listar');
    }
}
