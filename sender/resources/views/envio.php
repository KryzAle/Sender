<?php

// An example of using php-webdriver.
// Do not forget to run composer install before. You must also have Selenium server started and listening on port 4444.

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;


require_once('../vendor/autoload.php');



foreach($contactos as $item){
    
    $numeroTelefonico = $item->telefono;
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
    $element = $driver->wait()->until(
      WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('#main > footer > div._2i7Ej._14Mgc.copyable-area > div:nth-child(3) > button'))
    );
    $botonEnviar = $driver->findElement(
      WebDriverBy::cssSelector('#main > footer > div._2i7Ej._14Mgc.copyable-area > div:nth-child(3) > button')
    );
    $botonEnviar->click();

    sleep($intervalo);

  }

  echo "SUS MENSAJES HAN SIDO ENVIADOS ";