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
        $colecciondenombres = new Collection([
            ["Nombre", "Apellido", "Telefono"]
        ]);
        $contactos = Contacto::select("nombre","telefono")->get();
        foreach($contactos as $item){
            $nombrecompleto = explode(" ", $item->nombre);
            $colecciondenombres->push([$nombrecompleto[0],$nombrecompleto[1],$item->telefono]);
        }        
        return $colecciondenombres;
    }
}
