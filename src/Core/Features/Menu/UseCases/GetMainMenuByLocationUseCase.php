<?php
namespace Core\Features\Menu\UseCases;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\Menu\Facades\Menu;
use Core\Features\Menu\Models\GetMenuResult;
use Core\Features\Menu\ViewModels\GetMainMenuByLocationViewModel;

class GetMainMenuByLocationUseCase {
	public function invoke( $model ) {
		$result = new GetMenuResult();

		if ( null === $model || false === ( $model instanceof GetMainMenuByLocationViewModel ) ) {
			$result->message = sprintf( ErrorMessage::INVALID_DATE_PARAMETER, 'model' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$getDataResult = Menu::getRepo()->getMainMenuByLocation( $model->location );
		$result = $result->copyExceptData( $getDataResult );
		if ( false === $getDataResult->success ) {
			return $result;
		}

		$result->data = Menu::getMapper()->mapFromDbToEntity( $getDataResult->data, $model->location );

		return $result;
	}
}
