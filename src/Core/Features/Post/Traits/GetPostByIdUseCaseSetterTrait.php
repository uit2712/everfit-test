<?php
namespace Core\Features\Post\Traits;

use Core\Features\Post\UseCases\GetPostByIdUseCase;

trait GetPostByIdUseCaseSetterTrait {
	/**
	 * @var GetPostByIdUseCase
	 */
	private $getPostByIdUseCase;

	public function setGetPostByIdUseCaseInstance( $instance ) {
		if ( null !== $instance ) {
			$this->getPostByIdUseCase = $instance;
		}
	}
}
