<?php
namespace App\Core\Models;

use App\Core\Configs\Env;
use Elasticsearch\ClientBuilder;

class Base {
  protected $search_client;

  public function __construct() {
    # Create and config elastic search engine
    $this->search_client = ClientBuilder::create()->setHosts([ Env::ELASTIC_SEARCH_HOSTNAME ])->build();
  }

  public function deleteIndex($index) {
    $params = array('index' => $index);

    if($this->search_client->indices()->exists($params)) {
      $this->search_client->indices()->delete($params);
    }
  }

  public function indexExists($index) {
    return $this->search_client->indices()->exists(array('index' => $index ));
  }
}
