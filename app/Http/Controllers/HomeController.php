<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\ProductoModel;
use App\Models\EstrellasModel;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index'); 
    }

    
}
