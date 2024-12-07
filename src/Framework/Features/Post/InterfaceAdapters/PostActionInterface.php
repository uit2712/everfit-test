<?php
namespace Framework\Features\Post\InterfaceAdapters;

use Framework\InterfaceAdapters\ActionInterface;

interface PostActionInterface extends ActionInterface {
	/**
	 * @param int|null      $id Id.
	 * @param \WP_Post|null $dataAfter Data after.
	 * @param \WP_Post|null $dataBefore Data before.
	 */
	public function update( $id, $dataAfter, $dataBefore ): void;
}
