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
                    <h1>Detalle de Contacto</h1>
                    <h4>Nombre: {{$usuario->name}}</h4>
                    <h4>Email: {{$usuario->email}}</h4>
                </div>
                <a href="{{route('usuarios')}}" class="btn btn-success">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection
