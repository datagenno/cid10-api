<?php
$app->get(
  '/search[/{page}[/{results_by_page}]]',
  'App\V2\Controllers\Search:index'
);
