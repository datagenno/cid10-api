<?php
namespace App\V1\Models;

use App\Core\Models\Base;

class Search extends Base {
  public function createIndex() {
    $configs['index'] = 'search_api';
    $configs['body'] = [
      'settings' => [
        'number_of_shards'  => 3,
        'max_result_window' => 100000,

        'analysis' => [
          'analyzer' => [
            'folding' => [
              'tokenizer' => 'standard',
              'filter'    => ['lowercase', 'asciifolding']
            ]
          ]
        ]
      ],

      'mappings' => [
        'search' => [
          'properties' => [
            'code' => [
              'type'     => 'string',
              'analyzer' => 'folding'
            ],

            'value' => [
              'type'     => 'string',
              'analyzer' => 'folding'
            ]
          ]
        ]
      ]
    ];

    $this->search_client->indices()->create($configs);
  }

  public function import(array $data = array()) {
    $configs['index'] = 'search_api';
    $configs['type']  = 'search';
    $configs['body']  = $data;

    $this->search_client->index($configs);
  }

  public function search($terms, $page = 0, $results_by_page = 30) {
    $search_results = $this->search_client->search(
      $this->getSearchConfig($terms, $page, $results_by_page)
    );

    # Get total results
    $total = $search_results['hits']['total'];

    $response = array(
      'terms'        => $terms,
      'found'        => $total,
      'per_page'     => $results_by_page,
      'displayed'    => count($search_results['hits']['hits']),
      'pages'        => floor($total / $results_by_page),
      'current_page' => (int)$page,
      'results'      => $this->getResults($search_results)
    );

    return $response;
  }

  private function getSearchConfig($terms, $page = 0, $results_by_page = 30) {
    $configs['index'] = 'search_api';
    $configs['size']  = $results_by_page;
    $configs['from']  = floor($page * $results_by_page);
    $configs['body'] = [
      'query' => [
        'bool' => [
          'should' => [
            'query_string' => [
              'query'            => $terms,
              'boost'            => 3,
              'analyzer'         => 'folding',
              'analyze_wildcard' => true,
              'fields'           => ['code', 'value']
            ]
          ]
        ]
      ]
    ];

    return $configs;
  }

  private function getResults($search_results) {
    if($search_results['hits']['total'] == 0) {
      return array();
    }

    return array_map(function($item) {
      return $item['_source'];
    }, $search_results['hits']['hits']);
  }
}
