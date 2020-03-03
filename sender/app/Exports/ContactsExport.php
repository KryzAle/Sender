<?php

namespace App\Exports;

use App\Contacto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class ContactsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $usuarioact= auth()->id();
        $colecciondenombres = new Collection([
            ["Nombre", "Apellido", "Telefono"]
        ]);
        if(auth()->user()->hasRole('administrador')){
            $contactos = Contacto::select("nombre","telefono")->get();
        }
        if(auth()->user()->hasRole('tecnico')||auth()->user()->hasRole('usuario')){
            $contactos = Contacto::select("nombre","telefono")->where('usuario',$usuarioact)->get();
        }
        foreach($contactos as $item){
            $nombrecompleto = explode(" ", $item->nombre);
            $colecciondenombres->push([$nombrecompleto[0],$nombrecompleto[1],$item->telefono]);
        }        
        return $colecciondenombres;
    }
}
