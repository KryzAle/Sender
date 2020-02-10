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
                    <form method="POST" action="{{ route('contactos.update',$contacto->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            <div class="col-7">
                            <input type="text" class="form-control" placeholder="Nombre" value="{{$contacto->nombre}}" name="nombre" required>
                            </div>
                            <div class="col">
                            <input type="text" class="form-control" placeholder="Telefono" value="{{$contacto->telefono}}" name="telefono" required>
                            </div>
                            <div class="col">
                            <input type="text" class="form-control" placeholder="Observacion" value="{{$contacto->observacion}}" name="observacion">
                            </div>
                        </div>
                        <br>
                    <button class="btn btn-warning" type="submit">Actualizar</button>
                    <a href="{{route('home')}}" class="btn btn-success">Volver</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
