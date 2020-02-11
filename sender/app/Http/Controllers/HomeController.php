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
        $usuarioactivo= auth()->id();
        if(auth()->user()->email=="administrador@iconosistemas.com"){
            $contactos = App\Contacto::paginate(50);
        }
        else{
            $contactos = App\Contacto::where('usuario',$usuarioactivo)->paginate(50);
        }
        return view('home',compact('contactos'));
    }
    public function detalle($id){
        $contacto = App\Contacto::findOrFail($id);
        return view('contactos.detalle',compact('contacto'));
    }
    public function editar($id){
        $contacto = App\Contacto::findOrFail($id);
        return view('contactos.editar',compact('contacto'));
    }
    public function update(Request $request,$id){
        $contactoUpdate = App\Contacto::findOrFail($id);
        $contactoUpdate->nombre = $request->nombre;
        $contactoUpdate->telefono = $request->telefono;
        $contactoUpdate->observacion = $request->observacion;
        $contactoUpdate->save();
        return back()->with('mensaje','Contacto Actualizado');
    }
    public function eliminar($id){
        $contactoEliminar = App\Contacto::findOrFail($id);
        $contactoEliminar->delete();
        return back()->with('status','Contacto Eliminado');
    }
    public function envio(Request $request){
        $tiempoespera = $request->wait;
        $intervalo = $request->interval;
        $mensaje = $request->mensaje;
        //$mensaje = "Hola amigo";
        $usuarioactivo= auth()->id();
        $contactos = App\Contacto::where('usuario',$usuarioactivo)->get();
        return view('envio',compact(['contactos','mensaje','tiempoespera','intervalo']));
    }
}
