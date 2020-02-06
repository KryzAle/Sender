<?php

// An example of using php-webdriver.
// Do not forget to run composer install before. You must also have Selenium server started and listening on port 4444.

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;


require_once('vendor/autoload.php');

$options = new ChromeOptions();
$options->setExperimentalOption('debuggerAddress','localhost:9014');

// This is where Selenium server 2/3 listens by default. For Selenium 4, Chromedriver or Geckodriver, use http://localhost:4444/
$host = 'http://localhost:4444';
$caps = DesiredCapabilities::chrome();
$caps->setCapability(ChromeOptions::CAPABILITY, $options);

$driver = RemoteWebDriver::create($host, $caps);


$driver->get('https://web.whatsapp.com/send?phone=593979358929&text=mensaje&source&data');

echo "El titulo de la pagina es '" . $driver->getTitle() . "'\n";

echo "La url actual es'" . $driver->getCurrentURL() . "'\n";

/*$element = $driver->wait()->until(
    WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::className('_3u328 copyable-text selectable-text'))
);*/
// find element of 'History' item in menu
$driver->manage()->timeouts()->implicitlyWait(8);

$driver->getKeyboard()
  ->sendKeys(array(
    WebDriverKeys::TAB,
  ));



// close the browser
$driver->quit();