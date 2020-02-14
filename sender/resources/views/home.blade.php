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
                        
                        <button class="btn btn-info">Importar Contactos</button>
                    </form>
                    <form method="POST" class="form-group" action="{{ route('envio') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf
                        <label for="texto">Mensaje</label>
                        <textarea class="form-control"  placeholder="Ingrese su mensaje" 
                        name="mensaje" rows="5" id="texto" name="texto" required></textarea>
                        <br>
                        <div class="container">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="multi" name="multi"  onclick="habilitaMultimedia('multimedia')" />
                                <label class="form-check-label" for="multi">Insertar Multimedia</label>
                            </div>
                            <div class="container">
                                <label for="archivo"><b>Archivo: </b></label><br>
                                <input accept="image/*,video/mp4,video/3gpp,video/quicktime" type="file"  name="multimedia" id="multimedia" disabled="true" required>
                            </div>
                            <br>
                        </div>
                        
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
                    <div class="form-row">
                        <div class="col">
                            Bienvenido a continuacion puede visualizar sus contactos registrados <br>
                        </div>
                        <div class="col">
                        <a href="{{route('eliminarlote')}}" class="btn btn-danger">Eliminar lote de Contactos</a><br>
                        </div>
                    </div>
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
                                    <a class="btn btn-outline-primary" href="{{route('contactos.detalle',$item)}}">Detalle</a>
                                    <a href="{{route('contactos.editar', $item)}}" class="btn btn-outline-success">Editar</a>
                                    <form action="{{ route('contactos.eliminar', $item) }}" class="d-inline" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger">Eliminar</button>
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
<script>
    function habilitaMultimedia(campo)
    {
        var estadoActual = document.getElementById(campo);
                        
        estadoActual.disabled = !estadoActual.disabled;
    }
</script>


@endsection
