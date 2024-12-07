<?php
namespace Framework\Features\Post\Facades;

use Framework\Features\Post\Action\PostAction;
use Framework\Features\Post\InterfaceAdapters\PostActionInterface;

class PostHooks {
	/**
	 * @var PostActionInterface|null
	 */
	private static $action;

	public static function getAction() {
		if ( null === self::$action ) {
			self::$action = new PostAction();
		}

		return self::$action;
	}
}
