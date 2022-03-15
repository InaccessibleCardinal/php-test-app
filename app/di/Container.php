<?php 
declare(strict_types = 1);

namespace App\di;

class Container {
  private array $config;
  public function __construct(array $config) {
    $this->config = $config;
  }
  
  public function getInstance(string $key) {
    $classExists = array_key_exists($key, $this->config);
    if ($classExists) {
      $class = $this->config[$key]['class'];
      return $this->createAutowiredInstance($class);  
    }
    throw new \Exception('class '. $key . ' is not configured in this container.');
  }

  private function checkClassNeedsAutowiring(string $className) {
    return array_key_exists($className, $this->config);
  }

  private function getClass($arg) {
    $className = @$arg->getClass()->name;
    if ($this->checkClassNeedsAutowiring($className)) {
      return $this->createAutowiredInstance($this->config[$className]['class']);
    }
    return new $className();
  }

  function createAutowiredInstance($class) {
    $refClass = new \ReflectionClass($class);
    $args = $refClass->getConstructor()->getParameters();
    $argsClasses = array_map([$this, 'getClass'], $args);
    return $refClass->newInstanceArgs($argsClasses);
  }
}