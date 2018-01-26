<?php
namespace App\V2\Controllers;

use App\V2\Models\Search as SearchModel;

class Search {
  public function index($request, $response, $args) {
    $terms           = @$request->getQueryParam('q');
    $page            = @$args['page'] ?: 0;
    $results_by_page = @$args['results_by_page'] ?: 30;

    # Remove space for treating code search
    $terms = preg_replace('/(?<=[a-zA-Z])\s+(?=\d)/',"", $terms);

    $model = new SearchModel();
    $data  = $model->search($terms, $page, $results_by_page);

    return $response->withJson($data);
  }
}
