@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                
                <div class="card-header">
                    <a class="btn btn-warning" href="{{ route('home') }}">Volver</a>
                </div>

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
                            <label for="numenvios"><b>Numero de envios antes de pausar </b>(Este numero indica la cantidad de mensajes que se envian antes de realizar la pausa) </label><br>
                            <input type="number" value="50" min="1" max="100" class="form-control" placeholder="Numero de mensajes" name="numenvios" required>
                            </div>
                            <div class="col">
                            <label for="tiempopause"><b>Tiempo de pausa (min.) </b> (Este es un valor sugerido, el valor indica el tiempo de espera antes de reanudar los envios) </label><br>
                            <input type="number" value="20" min="20" class="form-control" placeholder="Tiempo de pausa" name="tiempopause" required>
                            </div>
                        </div>
                        <br>
                        <div class="container-fluid">
                            <button class="btn btn-success btn-lg btn-block" type="submit" >Enviar Mensajes</button>
                        </div>
                    </form>
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
