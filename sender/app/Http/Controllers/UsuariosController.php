<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;


class UsuariosController extends Controller
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
        $usuarios = App\User::paginate(50);
        return view('usuarios',compact('usuarios'));
    }
    public function detalle($id){
        $usuario = App\User::findOrFail($id);
        return view('usuarios.detalle',compact('usuario'));
    }
    public function editar($id){
        $usuario = App\User::findOrFail($id);
        return view('usuarios.editar',compact('usuario'));
    }
    public function update(Request $request,$id){
        $usuarioUpdate = App\User::findOrFail($id);
        $usuarioUpdate->name= $request->nombre;
        $usuarioUpdate->email = $request->email;
        $usuarioUpdate->password = Hash::make($request->password);
        $usuarioUpdate->save();
        return back()->with('mensaje','Contraseña actualizada');
    }
    public function eliminar($id){
        $usuarioEliminar = App\User::findOrFail($id);
        $usuarioEliminar->delete();
        return back()->with('status','Usuario Eliminado');
    }
}
