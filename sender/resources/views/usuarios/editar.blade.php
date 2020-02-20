@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Panel</div>

                <div class="card-body">
                    @if (session('mensaje'))
                        <div class="alert alert-success" role="alert">
                            {{ session('mensaje') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('usuarios.update',$usuario->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control" placeholder="Nombre" value="{{$usuario->name}}" name="nombre" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control" placeholder="Email" value="{{$usuario->email}}" name="email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Contraseña Nueva:</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Contraseña" name="password" required>
                            </div>
                        </div>
                        <br>
                    <button class="btn btn-warning" type="submit">Cambiar Contraseña</button>
                    <a href="{{route('usuarios')}}" class="btn btn-success">Volver</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
