<?php
$app->get('/search/{terms}[/{page}[/{results_by_page}]]', 'App\V1\Controllers\Search:index');
