<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;


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
       // if(auth()->user()->email=="administrador@iconosistemas.com"){
        if(auth()->user()->hasRole('administrador')){
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
    public function eliminarlote(){
        $usuarioact= auth()->id();
        $contactoslote = App\Contacto::where('usuario',$usuarioact)->get();
        foreach($contactoslote as $item){
            $item->usuario = 1;
            $item->save();
        }
        return back()->with('mensaje','Lote de Contactos Eliminado');
    }
    public function eliminar($id){
        $contactoEliminar = App\Contacto::findOrFail($id);
        $contactoEliminar->delete();
        return back()->with('status','Contacto Eliminado');
    }
    public function envio(Request $request){
        if($request->file('multimedia')!=NULL){
            $path = $request->file('multimedia')->store('public');
            $size = Storage::size($path);
            if($size>5242880){
            //if($size>15728640){ 
                return back()->with('error','Se ha exedido el tamaño de 5 mb en el archivo multimedia');
            }
            $mensajeconmultimedia="si";
        }else{
            $path ="no hay path";
            $mensajeconmultimedia="no";
        }
        $tiempoespera = $request->wait;
        $intervalo = $request->interval;
        $mensaje = $request->mensaje;
        $usuarioactivo= auth()->id();
        if(auth()->user()->hasRole('administrador')){
            $contactos = App\Contacto::all();
        }else{
            $contactos = App\Contacto::where('usuario',$usuarioactivo)->get();
        }
        $data = array(
            'parametro' => auth()->user()->email,
        );
        Mail::send('emails.envioiniciado', $data, function ($message) {
            $message->from('iconosender@gmail.com', 'Icono Sender');

            $message->to('iconosender@gmail.com')->subject('¡Nuevo envio!');
         });
        return view('envio',compact(['contactos','mensaje','tiempoespera','intervalo','path','mensajeconmultimedia']));
    }
}
