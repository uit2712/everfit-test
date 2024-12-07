<?php
namespace Core\Features\Menu\UseCases;

use Core\Constants\ApiResponseCode;
use Core\Constants\ErrorMessage;
use Core\Features\Menu\Facades\Menu;
use Core\Features\Menu\Models\GetListMenuItemsResult;
use Core\Features\Menu\ViewModels\GetListMenuItemsOfMenuByLocationViewModel;

class GetListMenuItemsOfMenuByLocationUseCase {
	public function invoke( $model ) {
		$result = new GetListMenuItemsResult();

		if ( null === $model || false === ( $model instanceof GetListMenuItemsOfMenuByLocationViewModel ) ) {
			$result->message = sprintf( ErrorMessage::INVALID_DATE_PARAMETER, 'model' );
			$result->responseCode = ApiResponseCode::HTTP_BAD_REQUEST;
			return $result;
		}

		$getMenuResult = Menu::getRepo()->getMainMenuByLocation( $model->location );
		if ( $getMenuResult->isHasObjectData() === false ) {
			$result = $result->copyExceptData( $getMenuResult );
			return $result;
		}

		$menu = Menu::getMapper()->mapFromDbToEntity( $getMenuResult->data );

		$getDataResult = Menu::getRepo()->getListMenuItemsOfMenu( $menu->id );
		$result = $result->copyExceptData( $getDataResult );
		if ( false === $getDataResult->success ) {
			return $result;
		}

		$result->data = Menu::getMapper()->mapFromDbToListMenuItemEntities( $getDataResult->data );

		return $result;
	}
}
