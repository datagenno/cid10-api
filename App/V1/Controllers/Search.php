<?php
namespace App\V1\Controllers;

use App\V1\Models\Search as SearchModel;

class Search {
  public function index($request, $response, $args) {
    $terms           = @$args['terms'];
    $page            = @$args['page'] ?: 0;
    $results_by_page = @$args['results_by_page'] ?: 30;

    $model = new SearchModel();
    $data  = $model->search($terms, $page, $results_by_page);

    return $response->withJson($data);
  }
}
