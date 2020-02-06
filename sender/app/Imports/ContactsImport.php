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
            'nombre' => $row[0],
            'telefono' => $row[1],
            'usuario' => auth()->id(),
        ]);
    }
}
