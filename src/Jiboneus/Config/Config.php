<?php

namespace Jiboneus\Config;

/**
 *
 * Config
 *
 * Core class to handle configuration values
 *
 */
class Config {
  
  /**
   *
   * Static config array. Contains all config values
   *
   * @var array
   *
   */
  private $_config = array();

  /**
   *
   * Path to config array.
   *
   * @var string
   *
   */
  private $_config_path;

  /**
   *
   * Class constructor
   *
   * @param string $file
   *
   */
  public function __construct($file = null) {
    if($file != null) {
      $this->setConfigPath($file);
      $this->loadConfig();
    }
    return $this;
  }

  public function setConfigPath($file = null) {
    $this->_config_path = $file;
    return $this;
  }

  public function getConfigPath() {
    return $this->_config_path;
  }

  /**
   *
   * Load configuration file load to $config array
   *
   * @param string  $file   The path to the config file
   *
   * @throws \InvalidFileException
   *
   */
  public function loadConfig($file = null) {
    if($file != null) {
      $this->_config_path = $file;
    }

    if(!file_exists($this->_config_path)) {
      throw new \Exception(sprintf('The file "%s" does not exist.', $this->_config_path));
    } else {
      require $this->_config_path;
      $this->_config = $conf;
    }
  }

  /**
   *
   * Retrive config data
   *
   * @param string  $key      Config array key
   * @param string  $default  The default value if none
   *
   */
  public function get($key = null, $default = null) {
    if(empty($key)) {
      return $this->_config;
    }
    return (isset($this->_config[$key]) ? $this->_config[$key] : $default);
  }

  /**
   *
   * Set config data
   *
   * @param string  $key
   * @param string  $dafault
   *
   */
  public function set($key, $value = null) {
    if(is_array($key)) {
      $this->_config = array_merge($this->_config, $key);
    } else {
      $this->_config[$key] = $value;
    }
  }

}
