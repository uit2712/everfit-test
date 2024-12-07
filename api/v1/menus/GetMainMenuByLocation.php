<?php

use Core\Helpers\ResponseHelper;
use Core\Features\Menu\Facades\MenuApi;

require_once '../../../vendor/autoload.php';

$response = MenuApi::getMainMenuByLocation( $_GET );
ResponseHelper::renderJson( $response, $response->responseCode );
