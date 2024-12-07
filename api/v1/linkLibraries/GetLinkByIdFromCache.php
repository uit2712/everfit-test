<?php

use Core\Features\LinkLibrary\Facades\LinkLibraryApi;
use Core\Helpers\ResponseHelper;

require_once '../../../vendor/autoload.php';

$response = LinkLibraryApi::getLinkByIdFromCache( $_GET );
ResponseHelper::renderJson( $response, $response->responseCode );
