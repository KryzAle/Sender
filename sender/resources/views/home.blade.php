@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
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
                   
                    <br>
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
                    <div class="form-row">
                        <div class="col">
                            <a class="btn btn-success" href="{{ route('parametros') }}">Siguiente...</a>
                        </div>
                        <div class="col">
                            <a class="btn btn-warning" href="{{ route('contacts.excel') }}">Exportar su lista de Contactos</a>
                        </div>
                        <div class="col">
                            <a href="{{route('eliminarlote')}}" class="btn btn-danger">Eliminar todos los Contactos</a><br>
                        </div>
                    </div>
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
