@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                

                @if(@Auth::user()->hasRole('administrador'))
                    <div class="card-header">Bienvenido Administrador</div>
                @endif
                @if(@Auth::user()->hasRole('usuario'))
                    <div class="card-header">Bienvenido Usuario</div>
                @endif
                @if(@Auth::user()->hasRole('tecnico'))
                    <div class="card-header">Bienvenido Tecnico</div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('contacts.import.excel') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        @if(Session::has('message'))
                        <div class="alert alert-success">
                            {{ Session::get('message') }}
                        </div>
                        @endif
                        <div class="form-row">
                            <div class="col">
                                <input type="file" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            </div>
                            <div class="col">
                                <button class="btn btn-info">Importar Contactos</button>
                            </div>
                        </div>
                    </form>
                    <form method="POST" class="form-group" action="{{ route('envio') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf
                        <label for="texto">Mensaje</label>
                        <textarea class="form-control"  placeholder="Ingrese su mensaje" 
                        name="mensaje" rows="3" id="texto" name="texto" required></textarea>
                        <br>
                        <div class="container">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="multi" name="multi"  onclick="habilitaMultimedia('multimedia')" />
                                <label class="form-check-label" for="multi">Insertar Multimedia (Recuerde que el archivo multimedia no debe superar los 15Mb)</label>
                            </div>
                            <div class="container">
                                <label for="archivo"><b>Archivo: </b></label><br>
                                <input accept="image/*,video/mp4,video/3gpp,video/quicktime" type="file"  name="multimedia" id="multimedia" disabled="true" required>
                            </div>
                            <br>
                        </div>
                        
                        <div class="form-row">
                            <div class="col">
                            <label for="wait"><b>Tiempo de espera(seg.) </b>(Este es un valor sugerido, recuerde que esto depende de su velocidad de conexion a internet) </label><br>
                            <input type="number" value="25" min="1" class="form-control" placeholder="Tiempo de espera(seg)" name="wait" required>
                            </div>
                            <div class="col">
                            <label for="interval"><b>Intervalo entre cada envio (seg.) </b> (Este es un valor sugerido, reducirlo podría provocar su bloqueo de numero de Whatsapp) </label><br>
                            <input type="number" value="30" min="1" class="form-control" placeholder="Intervalo de envio de mensajes(seg)" name="interval" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                            <label for="wait"><b>Numero de envios antes de pausar </b>(Este es un valor sugerido, este valor es el ) </label><br>
                            <input type="number" value="25" min="1" class="form-control" placeholder="Tiempo de espera(seg)" name="wait" required>
                            </div>
                            <div class="col">
                            <label for="interval"><b>Tiempo de pausa (seg.) </b> (Este es un valor sugerido, reducirlo podría provocar su bloqueo de numero de Whatsapp) </label><br>
                            <input type="number" value="30" min="1" class="form-control" placeholder="Intervalo de envio de mensajes(seg)" name="interval" required>
                            </div>
                        </div>
                        <br>
                        <div class="container-fluid">
                            <button class="btn btn-success btn-lg btn-block" type="submit" >Enviar Mensajes</button>
                        </div>
                    </form>
                    <div class="form-row">
                        <div class="col">
                            Aqui puede visualizar los contactos almacenados a los que se les realizara el envio<br>
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
                    @if(@Auth::user()->hasRole('administrador'))
                        {{$contactos->links()}}
                    @endif
                    @if(@Auth::user()->hasRole('usuario'))
                        {{$contactos->links()}}
                    @endif
                    @if(@Auth::user()->hasRole('administrador'))   
                        <a class="btn btn-success" href="{{ route('contacts.excel') }}">Descargar Lista de Contactos</a>
                    @endif
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
