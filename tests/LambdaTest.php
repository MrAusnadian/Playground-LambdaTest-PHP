<?php

require 'vendor/autoload.php';

$GLOBALS['LT_USERNAME'] = getenv('LT_USERNAME');
if(!$GLOBALS['LT_USERNAME']) $GLOBALS['LT_USERNAME'] = "************************************";

$GLOBALS['LT_ACCESS_KEY'] = getenv('LT_ACCESS_KEY');
if(!$GLOBALS['LT_ACCESS_KEY']) $GLOBALS['LT_ACCESS_KEY'] = "*****************************************";

$GLOBALS['LT_BROWSER'] = getenv('LT_BROWSER');
if(!$GLOBALS['LT_BROWSER']) $GLOBALS['LT_BROWSER'] = "chrome";

$GLOBALS['LT_BROWSER_VERSION'] = getenv('LT_BROWSER_VERSION');
if(!$GLOBALS['LT_BROWSER_VERSION']) $GLOBALS['LT_BROWSER_VERSION'] ="latest";

$GLOBALS['LT_OPERATING_SYSTEM'] = getenv('LT_OPERATING_SYSTEM');
if(!$GLOBALS['LT_OPERATING_SYSTEM']) $GLOBALS['LT_OPERATING_SYSTEM'] = "win10";

class LambdaTest{
	
   protected static $driver;

   public function testAdd() {		
		
		$url = "https://". $GLOBALS['LT_USERNAME'] .":" . $GLOBALS['LT_ACCESS_KEY'] ."@hub.lambdatest.com/wd/hub";		
		$capability = array(
			"browserName" => $GLOBALS['LT_BROWSER'],
			"version" => $GLOBALS['LT_BROWSER_VERSION'],
			"platform" => $GLOBALS['LT_OPERATING_SYSTEM'],
			"name" => "PHPTestSample",
			"build" => "LambdaTestSampleApp",
			"network" => true,
			"visual" => true,
			"video" => true,
			"console" => true,
			"terminal" => true,
			"plugin" => "php-php_unit"
		);

		self::$driver = RemoteWebDriver::create($url, $capability); 		
				
		$itemName = 'Yey, Lets add it to list';
        self::$driver->get("https://lambdatest.github.io/sample-todo-app/");
        $element1 = self::$driver->findElement(WebDriverBy::name("li1"));
		$element1->click();
			
		$element2 = self::$driver->findElement(WebDriverBy::name("li2"));
        $element2->click();
			
		$element3 = self::$driver->findElement(WebDriverBy::id("sampletodotext"));
		$element3->sendKeys($itemName);
			
		$element4 = self::$driver->findElement(WebDriverBy::id("addbutton"));			
		$element4->click();
			
        self::$driver->wait(10, 500)->until(function($driver) {
           $elements = $driver->findElements(WebDriverBy::cssSelector("[class='list-unstyled'] li:nth-child(6) span"));
           return count($elements) > 0;
        });
		
		self::$driver->quit();
    }
			
}

  $lambdaTest = new LambdaTest();
  $lambdaTest->testAdd();
  

?>

