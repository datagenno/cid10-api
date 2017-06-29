<?php
namespace App\Core\Console\Commands;

use App\V1\Models\Search;

final class Import {
  use \App\Core\Utils\Singleton;

  public function run() {
    $json = file_get_contents(__DIR__ . "/../../Resources/cid10.json");
    $json = json_decode($json, true);

    $model = new Search;

    if(!$model->indexExists('search_api')) {
      $model->createIndex();
    }

    foreach($json as $data) {
      $model->import($data);
    }
  }
}
