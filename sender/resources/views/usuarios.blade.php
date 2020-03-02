@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-20">
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
                            Recuerde que desde la fecha de la creacion el usuario tiene un año para hacer uso de su cuenta, luego de transcurrido ese tiempo, pasará a inactivo<br>
                        </div>
                    </div>
                    <table class="table table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Email</th>
                                <th scope="col">Acciones</th>
                                <th scope="col">Fecha de creación</th>
                                <th scope="col">Fecha de expiración</th>
                                <th scope="col">Status</th>
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
                                <?php if ($item->email != "administrador@iconosistemas.com"): ?>
                                    <form action="{{ route('usuarios.eliminar', $item) }}" class="d-inline" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                                    </form> 
                                <?php endif; ?>
                                    
                                </td>
                                <td>{{$item->created_at->format('d-m-Y')}}</td>
                                <?php 
                                    $hoy = getdate();
                                    $fechaHoy= $hoy['mday']."/" .$hoy['mon'] ."/".$hoy['year'];
                                    $time = strtotime($fechaHoy);
                                    $fechaActual = date('d-m-Y',$time);
                                    $anioExpiracion = date('Y',strtotime($item->created_at->format('d-m-Y')));
                                    $anioExpiracion = (int)$anioExpiracion;
                                    $anioExpiracion++;
                                    $fechaExpiracion= $item->created_at->format('d-m') ."-".$anioExpiracion;
                                    $fechaExpiracion= date("d-m-Y", strtotime($fechaExpiracion));

                                ?>
                                <?php if ($item->email != "administrador@iconosistemas.com"): ?>
                                    <td>{{$fechaExpiracion}} </td>
                                    @if($fechaActual<$fechaExpiracion)
                                        <td  class="alert alert-success" role="alert">Activo</td>
                                    @else($fechaActual>$fechaExpiracion)
                                    <td  class="alert alert-danger" role="alert">Se requiere renovación</td>
                                    @endif
                                <?php endif; ?>
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
<?php 
    /*si te toca modificar este codigo, no me odies, ya estoy cansado, con sueño y hambre 
    estoy consciente de que no debo poner tanto codigo con validaciones del lado de la vista, 
    mejoralo,! si tienes dudas principalmente con la automatización escribeme
    kryzale@gmail.com
    Eso si que me costó jeje.
    */
?>