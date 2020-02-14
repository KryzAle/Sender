<?php

// An example of using php-webdriver.
// Do not forget to run composer install before. You must also have Selenium server started and listening on port 4444.

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\LocalFileDetector;


require_once('../vendor/autoload.php');


$mensajesenviados=0;
$mensajesnoenviados=0;
$pathEnvio = $path;

foreach($contactos as $item){
    
    $numeroTelefonico = $item->telefono;
    
    if($numeroTelefonico[0]=='0' && $numeroTelefonico[1]=='9' && strlen ( $numeroTelefonico )==10)
    {
        $numero = $rest = substr($numeroTelefonico, 1);
        $numeroTel = "593" . $numero;
        
        $options = new ChromeOptions();
        $options->setExperimentalOption('debuggerAddress','localhost:9014');
        
        // This is where Selenium server 2/3 listens by default. For Selenium 4, Chromedriver or Geckodriver, use http://localhost:4444/
        $host = 'http://localhost:4444';
        $caps = DesiredCapabilities::chrome();
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);
        
        $driver = RemoteWebDriver::create($host, $caps);
        $driver->get("https://web.whatsapp.com/send?phone=" . $numeroTel . "&text=" . $mensaje . "&source&data");
        sleep($tiempoespera);
        if($mensajeconmultimedia=="si"){
          $path  = substr($pathEnvio, 6);
          $botonAdjunto = $driver->findElement(WebDriverBy::cssSelector('#main > header > div._2kYeZ > div > div:nth-child(2) > div'));
          $botonAdjunto->click();
          sleep(5);
          $fileInput = $driver->findElement(WebDriverBy::cssSelector('#main > header > div._2kYeZ > div > div._3j8Pd.GPmgf > span > div > div > ul > li:nth-child(1) > button > input[type=file]'));
          $fileInput->setFileDetector(new LocalFileDetector());
          $filePath="C:/laragon/www/Sender/sender/public/storage" . $path ;
          $fileInput->sendKeys($filePath);
          $botonEnvioIMG = $driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('#app > div > div > div._2aMzp > div._10V4p._1jxtm > span > div > span > div > div > div.rK2ei.USE1O > span > div > div'))
          );
          $botonEnvioIMG = $driver->findElement(WebDriverBy::cssSelector('#app > div > div > div._2aMzp > div._10V4p._1jxtm > span > div > span > div > div > div.rK2ei.USE1O > span > div > div'));
          $botonEnvioIMG->click();
          $mensajesenviados=$mensajesenviados+1;
          sleep($intervalo);
        }else{
          //enviar solo texto
          $elements = $driver->findElements(WebDriverBy::cssSelector('#main > footer > div._2i7Ej._14Mgc.copyable-area > div:nth-child(3) > button'));

          if(!empty($elements)){
            $botonEnviar = $driver->wait()->until(
              WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('#main > footer > div._2i7Ej._14Mgc.copyable-area > div:nth-child(3) > button'))
            );          
    
            $botonEnviar = $driver->findElement(
              WebDriverBy::cssSelector('#main > footer > div._2i7Ej._14Mgc.copyable-area > div:nth-child(3) > button')
            );
            $botonEnviar->click();
            $mensajesenviados=$mensajesenviados+1;
            sleep($intervalo);
          }else{
            $mensajesnoenviados=$mensajesnoenviados+1;
          }
        }
    }
    else{
      $mensajesnoenviados=$mensajesnoenviados+1;
    }
  }
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Sender - Mensajes Enviados</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <!--<link href="./end_files/cover.css" rel="stylesheet">-->
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
      </main>

      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>Sender de <a href="http://www.iconosistemas.com/">Icono Sistemas</a></p>
        </div>
      </footer>
    </div>
</body>
</html>