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
                    <div class="form-row">
                        <div class="col">
                            Aqui puede visualizar los usuarios registrados<br>
                        </div>
                    </div>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Email</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($usuarios as $item)
                            <tr>
                                <th scope="row">{{$item->id}}</th>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>
                                    
                                    <a href="{{route('usuarios.editar', $item)}}" class="btn btn-outline-success"> Cambiar Contraseña </a>
                                    <form action="{{ route('usuarios.eliminar', $item) }}" class="d-inline" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                                    </form> 
                                </td> 
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$usuarios->links()}}
                    <a href="{{route('home')}}" class="btn btn-success">Volver al Panel</a>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
