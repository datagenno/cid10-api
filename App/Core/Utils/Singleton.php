<?php
namespace App\Core\Utils;

trait Singleton {
  final public static function getInstance() {
    static $instances = array();

    $calledClass = get_called_class();

    if (!isset($instances[$calledClass])) {
      $args  = func_get_args();
      $class = new \ReflectionClass($calledClass);

      if(empty($args)) {
        $instances[$calledClass] = $class->newInstanceArgs();
      } else {
        $instances[$calledClass] = $class->newInstanceArgs($args);
      }

    }

    return $instances[$calledClass];
  }

  final private function __clone() {}
}
