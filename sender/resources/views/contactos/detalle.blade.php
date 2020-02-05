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
                    <h4>Nombre: {{$contacto->nombre}}</h4>
                    <h4>Telefono: {{$contacto->telefono}}</h4>
                    <h4>Observacion: {{$contacto->observacion}}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
