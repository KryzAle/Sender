@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                

                @if(@Auth::user()->hasRole('administrador'))
                    <div class="card-header">Bienvenido Administrador</div>
                    @else
                    <div class="card-header">Bienvenido Usuario</div>
                @endif
                

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
                    <form method="POST" class="form-group" action="{{ route('envio') }}" >
                        @csrf
                        <label for="texto">Mensaje</label>
                        <textarea class="form-control"  placeholder="Ingrese su mensaje" 
                        name="mensaje" rows="5" id="texto" name="texto" required></textarea>
                        <br>
                        <div class="form-row">
                            
                            <div class="col">
                            <input type="number" min="1" class="form-control" placeholder="Tiempo de espera(seg)" name="wait" required>
                            </div>
                            <div class="col">
                            <input type="number" min="1" class="form-control" placeholder="Intervalo de envio de mensajes(seg)" name="interval" required>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-success" type="submit" >Enviar Mensajes</button>
                        
                    </form>

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
                                <td>
                                    <a class="btn btn-primary" href="{{route('contactos.detalle',$item)}}">Detalle</a>
                                    <a href="{{route('contactos.editar', $item)}}" class="btn btn-warning">Editar</a>
                                    <form action="{{ route('contactos.eliminar', $item) }}" class="d-inline" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form> 
                                </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>   
                    {{$contactos->links()}}
                    <a class="btn btn-success" href="{{ route('contacts.excel') }}">Descargar Lista de Contactos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
