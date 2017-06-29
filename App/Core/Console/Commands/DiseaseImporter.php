<?php
namespace App\Core\Console\Commands;

use App\V1\Models\Disease;

final class DiseaseImporter {
  use \App\Core\Utils\Singleton;

  public function run() {
    $json = file_get_contents(__DIR__ . "/../../Resources/diseases.json");
    $json = json_decode($json, true);

    $model = new Disease;

    if(!$model->indexExists('diseases_api')) {
      $model->createIndex();
    }
    
    foreach($json as $data) {
      $model->import($data);
    }
  }
}
