<?php


namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\LocalFileDetector;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;


require_once('../vendor/autoload.php');


$mensajesenviados=0;
$mensajesnoenviados=0;
$pathEnvio = $path;
$pilanoenviados = array();
foreach($contactos as $item){
    if(($mensajesenviados%$numenvios==0)&&($mensajesenviados!=0)){
      sleep($tiempopause*60);
    }    
    $numeroTelefonico = $item->telefono;
    
    if($numeroTelefonico[0]=='0' && $numeroTelefonico[1]=='9' && strlen ( $numeroTelefonico )==10)
    {
        $numero = $rest = substr($numeroTelefonico, 1);
        $numeroTel = "593" . $numero;
      try{
        $options = new ChromeOptions();
        $options->setExperimentalOption('debuggerAddress','localhost:9014');
        
        $host = 'http://localhost:4444';
        $caps = DesiredCapabilities::chrome();
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);
        
        $driver = RemoteWebDriver::create($host, $caps);
        $driver->get("https://web.whatsapp.com/send?phone=" . $numeroTel . "&text=Hola ". $item->nombre . ", " .$mensaje . "&source&data");

        sleep($tiempoespera + rand(1,9));
        $elements = $driver->findElements(WebDriverBy::cssSelector('#main > footer > div._2i7Ej._14Mgc.copyable-area > div:nth-child(3) > button'));

        if(!empty($elements)){
              if($mensajeconmultimedia=="si"){
                $botonAdjunto = $driver->findElement(WebDriverBy::cssSelector('#main > header > div._2kYeZ > div > div:nth-child(2) > div'));
                $botonAdjunto->click();
                sleep(5 + rand(1,5));
                $fileInput = $driver->findElement(WebDriverBy::cssSelector('#main > header > div._2kYeZ > div > div._3j8Pd.GPmgf > span > div > div > ul > li:nth-child(1) > button > input[type=file]'));
                $fileInput->setFileDetector(new LocalFileDetector());
                $filePath="C:/laragon/www/Sender/sender/storage/app/" . $pathEnvio ;
                                
                $fileInput->sendKeys($filePath);
                sleep(5 + rand(1,5));
                $botonEnvioIMG = $driver->wait()->until(
                  WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('#app > div > div > div._2aMzp > div._10V4p._1jxtm > span > div > span > div > div > div.rK2ei.USE1O > span > div > div'))
                );
                $botonEnvioIMG = $driver->findElement(WebDriverBy::cssSelector('#app > div > div > div._2aMzp > div._10V4p._1jxtm > span > div > span > div > div > div.rK2ei.USE1O > span > div > div'));
                $botonEnvioIMG->click();
                $mensajesenviados=$mensajesenviados+1;
                sleep($intervalo + rand(1,9));
            }else{
              //enviar solo texto
              
                $botonEnviar = $driver->wait()->until(
                  WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('#main > footer > div._2i7Ej._14Mgc.copyable-area > div:nth-child(3) > button'))
                );          
        
                $botonEnviar = $driver->findElement(
                  WebDriverBy::cssSelector('#main > footer > div._2i7Ej._14Mgc.copyable-area > div:nth-child(3) > button')
                );
                $botonEnviar->click();
                $mensajesenviados=$mensajesenviados+1;
                sleep($intervalo + rand(1,9));
            }
            
        }else{
            array_push($pilanoenviados, $item->nombre . " ". $item->telefono);
            $mensajesnoenviados=$mensajesnoenviados+1;
        }
      }catch(\Exception $e){
        $mensajeError = $e->getResults();
        $mensajeError = $mensajeError['value'];
        $mensajeError = $mensajeError['error'];
        //dd($e);
          if($mensajeError=="unexpected alert open"){
            $driver->navigate()->refresh();
            $driver->wait()->until(
            WebDriverExpectedCondition::alertIsPresent(),
            'I am expecting an alert!'
          );
          sleep(5);
          $driver->switchTo()->alert()->accept();
          array_push($pilanoenviados, $item->nombre ." ". $item->telefono);
          $mensajesnoenviados=$mensajesnoenviados+1;
        }else{
          $driver->navigate()->refresh();
        }
      }
    }
    else{
      array_push($pilanoenviados, $item->nombre ." ". $item->telefono);
      $mensajesnoenviados=$mensajesnoenviados+1;
    }
  }
  if($mensajeconmultimedia=="si"){
    Storage::delete($pathEnvio);
  }
$data = array(
  'mail' => auth()->user()->email,
  'enviados' => $mensajesenviados,
  'noenviados' => $mensajesnoenviados,
);
Mail::send('emails.enviofinalizado', $data, function ($message) {
    $message->from('iconosender@gmail.com', 'Icono Sender');

    $message->to('iconosender@gmail.com')->subject('¡Envio Finalizado!');
 });
  ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Sender - Mensajes Enviados</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="https://getbootstrap.com/docs/4.1/examples/cover/cover.css" rel="stylesheet">

  </head>

  <body class="text-center">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
          <h3 class="masthead-brand">Sender</h3>
        </div>
      </header>

      <main role="main" class="inner cover">
        <h1 class="cover-heading">¡Listo!</h1>
        <p class="lead">Mensajes enviados: <?= $mensajesenviados ?> - Mensajes no enviados: <?= $mensajesnoenviados ?> </p>
        <p class="lead">
          <a href="{{route('home')}}" class="btn btn-lg btn-secondary">Volver al Panel</a>
        </p>
        <table class="table table-hover">
          <thead class="thead-light">
            <tr >
              <th scope="col">Mensajes no enviados</th>
            </tr>
          </thead>
          <tbody>
              @foreach($pilanoenviados as $items)
                <tr class="table-light">
                  <td>{{$items}}</td>
                </tr>
               @endforeach
          </tbody>
        </table>

      </main>

      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>Sender de <a href="http://www.iconosistemas.com/">Icono Sistemas</a></p>
        </div>
      </footer>
    </div>
</body>
</html>