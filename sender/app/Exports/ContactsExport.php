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
        return Contacto::where('usuario',$usuarioactivo)->select("nombre","telefono")->get();
    }
}
