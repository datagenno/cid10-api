<?php
$app->get('/diseases/{terms}[/{page}[/{results_by_page}]]', 'App\V1\Controllers\Disease:index');
