<?php
namespace Core\Features\Post\InterfaceAdapters;

use Core\Features\Post\Entities\PostEntity;

interface PostMapperInterface {
	/**
	 * @param mixed $data Data.
	 *
	 * @return PostEntity|null
	 */
	public function mapFromDbToEntity( $data );

	/**
	 * @param mixed $data Data.
	 *
	 * @return PostEntity[]
	 */
	public function mapFromDbToListEntities( $data );
}
