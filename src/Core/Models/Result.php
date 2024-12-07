<?php

namespace Core\Models;

use Core\Constants\ApiResponseCode;
use Core\Helpers\ArrayHelper;
use Core\Helpers\StringHelper;

/**
 * @OA\Schema()
 */
class Result {
	/**
	 * @OA\Property(type="boolean")
	 */
	public $success = false;
	/**
	 * @OA\Property(type="string")
	 */
	public $message = '';
	/**
	 * @OA\Property(type="number")
	 */
	public $responseCode = ApiResponseCode::HTTP_OK;
	public $data = null;

	/**
	 * @param null|Result $source Source.
	 */
	public function copyExceptData( $source ) {
		if ( null === $source ) {
			return $this;
		}

		$this->success = $source->success;
		$this->message = $source->message;
		$this->responseCode = $source->responseCode;

		return $this;
	}

	/**
	 * @param null|Result $source Source.
	 */
	public function copy( $source ) {
		if ( null === $source ) {
			return $this;
		}

		$this->success = $source->success;
		$this->message = $source->message;
		$this->data = $source->data;
		$this->responseCode = $source->responseCode;

		return $this;
	}

	public function isHasObjectData() {
		return $this->success && null !== $this->data;
	}

	public function isHasArrayData() {
		return $this->success && ArrayHelper::isHasItems( $this->data );
	}

	public function isHasErrorMessage() {
		return false === $this->success && StringHelper::isHasValue( $this->message );
	}
}
