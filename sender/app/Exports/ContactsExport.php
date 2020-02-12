<?php

namespace App\Exports;

use App\Contacto;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContactsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $usuarioactivo= auth()->id();
        if(auth()->user()->hasRole('administrador')){
            return Contacto::select("nombre","telefono")->get();
        }else{
            return Contacto::where('usuario',$usuarioactivo)->select("nombre","telefono")->get();
        }
    }
}
