<?php
require_once "PHPUnit/Autoload.php";
require_once "../src/Jiboneus/Config/Config.php";

class ConfigTest extends PHPUnit_Framework_TestCase {
  protected $c;

  // -- test config creation
  public function testConfigPathInst() {
    $path = "settings.php";
    $c = new \Jiboneus\Config\Config($path);
    
    $expected = $path;
    $actual = $c->getConfigPath();
    $this->assertEquals($expected, $actual);
    
    unset($c);
  }

  // -- test set path
  public function testConfigSetPath() {
    $path = "testconfig.php";
    $c = new \Jiboneus\Config\Config();
    $c->setConfigPath($path);

    $expected = $path;
    $actual = $c->getConfigPath();
    $this->assertEquals($expected, $actual);

    unset($c);
  }

  // -- test loading config file
  public function testConfigLoadFileException() {
    $path = "falsefile.php";
    $expected = 'The file "falsefile.php" does not exist.';

    $c = new \Jiboneus\Config\Config();    
    try {
      $c->loadConfig($path);
      $actual = "file loaded.";
    } catch (Exception $e) {
      $actual = $e->getMessage();
    }
    $this->assertEquals($expected, $actual);

    unset($c);

    $c = new \Jiboneus\Config\Config();
    $c->setConfigPath($path);
    try {
      $c->loadConfig();
      $actual = "file loaded.";
    } catch (Exception $e) {
      $actual = $e->getMessage();
    }
    $this->assertEquals($expected, $actual);
    
    unset($c);
    
    try {
      $c = new \Jiboneus\Config\Config($path);
      $actual = "file loaded.";
    } catch (Exception $e) {
      $actual = $e->getMessage();
    }
    $this->assertEquals($expected, $actual);
    
    unset($c);
  }

  // -- test loading config file
  public function testConfigLoadFile() {
    $path = "settings.php";
    $c = new \Jiboneus\Config\Config($path);

    $arr = $c->get();
    $this->assertTrue(is_array($arr));

    unset($c);
  }

  // -- test getting data
  public function testConfigGetData() {
    $path = "settings.php";
    $c = new \Jiboneus\Config\Config($path);

    $expected = "test app";
    $actual = $c->get('name');
    $this->assertEquals($expected, $actual);

    $expected = "test";
    $actual = $c->get('enviroment');
    $this->assertEquals($expected, $actual);

    $expected = "random";
    $actual = $c->get('nonkey', $expected);
    $this->assertEquals($expected, $actual);

    $expected = null;
    $actual = $c->get('randomkey');
    $this->assertEquals($expected, $actual);

    unset($c);
  }

  // -- test setting data
  public function testConfigSetData() {
    $path = "settings.php";
    $c = new \Jiboneus\Config\Config();

    $expected = "test data";
    $c->set('test_key', $expected);
    $actual = $c->get('test_key');
    $this->assertEquals($expected, $actual);
    
    unset($c);

    $c = new \Jiboneus\Config\Config();
    $arr = array(
      "website" => "test website",
      "description" => "website description"
    );
    $c->set($arr);
    $actual = $c->get();
    $this->assertTrue(is_array($actual));

    $expected = "test website";
    $actual = $c->get("website");
    $this->assertEquals($expected, $actual);

    $expected = "website description";
    $actual = $c->get("description");
    $this->assertEquals($expected, $actual);

    unset($c);
  }

  // -- test loading configuration for different enviroment
  public function testConfigEnviroment() {
    $path = "settings.php";
    $c = new \Jiboneus\Config\Config($path);

    $expected = "test.dev";
    $config = $c->get($c->get("enviroment"));
    $this->assertEquals($expected, $config["base_url"]);
    
    $expected = "localhost";
    $c->set("enviroment", "development");
    $config = $c->get($c->get("enviroment"));
    $this->assertEquals($expected, $config["base_url"]);
    
    $expected = "website.com";
    $c->set("enviroment", "production");
    $config = $c->get($c->get("enviroment"));
    $this->assertEquals($expected, $config["base_url"]);

    unset($c);
  }
}
