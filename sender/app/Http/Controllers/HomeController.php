<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $contactos = App\Contacto::all();
        return view('home',compact('contactos'));
    }
    public function detalle($id){
        $contacto = App\Contacto::findOrFail($id);
        return view('contactos.detalle',compact('contacto'));
    }
}
