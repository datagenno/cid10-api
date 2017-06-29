<?php
require_once('env.php');

return array(
  "paths" => array(
    "migrations" => "App/V1/resources/migrations",
    "seeds"      => "App/V1/resources/seeds"
  ),

  "environments" => array(
    "default_migration_table" => "phinxlog",
    "default_database"        => "db",

    "db" => array(
      "adapter"   => "mysql",
      "host"      => MYSQL_HOST,
      "name"      => MYSQL_DATABASE,
      "user"      => MYSQL_USERNAME,
      "pass"      => MYSQL_PASSWORD,
      "port"      => MYSQL_PORT,
      "charset"   => "utf8",
      "collation" => "utf8_unicode_ci"
    )
  )
);
