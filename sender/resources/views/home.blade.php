@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Panel</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    


                    <form action="{{ route('contacts.import.excel') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        @if(Session::has('message'))
                        <div class="alert alert-success">
                            {{ Session::get('message') }}
                        </div>
                        @endif

                        <input type="file" name="file">
                        
                        <button class="btn btn-danger">Importar Contactos</button>
                    </form>
                    <div class="form-group">
                        <label for="texto">Mensaje</label>
                        <textarea class="form-control"  rows="5" id="texto" name="texto"></textarea>
                    </div>

                    
                    <div class="form-group">
                            
                        <a class="btn btn-success" href="{{ route('envio') }}">Enviar Mensajes</a>
                    </div>
                    Bienvenido a continuacion puede visualizar sus contactos existentes <br>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($contactos as $item)
                            <tr>
                                <th scope="row">{{$item->id}}</th>
                                <td>{{$item->nombre}}</td>
                                <td>{{$item->telefono}}</td>
                                <td><a class="btn btn-primary" href="{{route('contactos.detalle',$item)}}">Detalle</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>   
                    <a class="btn btn-success" href="{{ route('contacts.excel') }}">Descargar Lista de Contactos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
