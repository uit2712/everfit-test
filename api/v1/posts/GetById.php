<?php

use Core\Features\Post\Facades\PostApi;
use Core\Helpers\ResponseHelper;

require_once '../../../vendor/autoload.php';

$response = PostApi::getById( $_GET );
ResponseHelper::renderJson( $response, $response->responseCode );
