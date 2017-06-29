#!/usr/bin/php
<?php
require_once(__DIR__ . "/../Configs/bootstrap.php");

$command_name = $argv[1];
$command_name = ucfirst($command_name);

$command_class = "App\\Core\\Console\\Commands\\{$command_name}";

if(class_exists($command_class)) {
  print("Starting command \n");

  try {
    $command_instance = $command_class::getInstance();
    $command_instance->run();

    print("Command successfully executed! \n");
  } catch(Exception $e) {
    print($e->getMessage() . " \n");
  }
} else {
  print("Not existing command \n");
}
