<?php

namespace App\Imports;

use App\Contacto;
use Maatwebsite\Excel\Concerns\ToModel;

class ContactsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Contacto([
            'nombre' => $row[0] ." ". $row[1],
            'telefono' => $row[2],
            'usuario' => auth()->id(),
        ]);
    }
}
