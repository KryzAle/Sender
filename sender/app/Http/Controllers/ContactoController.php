<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\ContactsExport;
use App\Imports\ContactsImport;

use App\Contacto;

class ContactoController extends Controller
{
    public function exportExcel()
    {
    	return Excel::download(new ContactsExport, 'contactos-list.xlsx');
    }

    public function importExcel(Request $request)
    {
        $file = $request->file('file');
        if($file==NULL){
            return back()->with('message', 'No ha cargado ningun archivo');
        }
        else{
            try{
                Excel::import(new ContactsImport, $file);
                return back()->with('message', 'Importación de contactos completada');

            }catch(\Exception $e){
                return back()->with('error', 'El Archivo ha sido truncado porque no tiene el formato esperado');

            }
        }
        

        
    }
}










