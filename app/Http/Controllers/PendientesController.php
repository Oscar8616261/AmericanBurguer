<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendientesController extends Controller
{
    public function index(){
        return view('pendientes.index');
    }
}
