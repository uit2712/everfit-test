<?php
namespace Core\Features\Menu\InterfaceAdapters;

use Core\Features\Menu\Entities\MenuEntity;
use Core\Features\Menu\Entities\MenuItemEntity;

interface MenuMapperInterface {
	/**
	 * @param \WP_Term    $data Data.
	 * @param string|null $location Location.
	 *
	 * @return MenuEntity|null
	 */
	public function mapFromDbToEntity( $data, $location = '' );

	/**
	 * @param \WP_Term $data Data.
	 *
	 * @return MenuItemEntity|null
	 */
	public function mapFromDbToMenuItemEntity( $data );

	/**
	 * @return MenuItemEntity[]
	 */
	public function mapFromDbToListMenuItemEntities( $data );
}
