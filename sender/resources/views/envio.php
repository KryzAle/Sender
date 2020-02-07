<?php

// An example of using php-webdriver.
// Do not forget to run composer install before. You must also have Selenium server started and listening on port 4444.

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;


require_once('../vendor/autoload.php');



for ($i = 1; $i <= 3; $i++) {
  

  $options = new ChromeOptions();
  $options->setExperimentalOption('debuggerAddress','localhost:9014');
  
  // This is where Selenium server 2/3 listens by default. For Selenium 4, Chromedriver or Geckodriver, use http://localhost:4444/
  $host = 'http://localhost:4444';
  $caps = DesiredCapabilities::chrome();
  $caps->setCapability(ChromeOptions::CAPABILITY, $options);
  
  $driver = RemoteWebDriver::create($host, $caps);
  $driver->getKeyboard()->sendKeys(
    array(WebDriverKeys::CONTROL, 'n')
  );
  $driver->get("https://web.whatsapp.com/send?phone=593979358929&text=hola%20amigo%20este%20es%20mi%20mensaje'" . $i . "'&source&data");


  echo "Espere a que se envien los mensajes \n ";


  $element = $driver->wait()->until(
    WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('#main > footer > div._2i7Ej._14Mgc.copyable-area > div:nth-child(3) > button'))
  );
  $botonEnviar = $driver->findElement(
    WebDriverBy::cssSelector('#main > footer > div._2i7Ej._14Mgc.copyable-area > div:nth-child(3) > button')
  );
  $driver->manage()->timeouts()->implicitlyWait(20);
  $botonEnviar->click();

  echo "Numero de mensajes enviados'" . $i . "'\n";
  sleep(10);

}