<?php
namespace Core\Features\Cache\ViewModels;

class CacheConfigViewModel {
	public $host     = '';
	public $port     = 6379;
	public $database = 0;

	public function setHost( $host ) {
		$this->host = $host;

		return $this;
	}

	public function setPort( $port ) {
		$this->port = $port;

		return $this;
	}

	public function setDatabase( $database ) {
		$this->database = $database;

		return $this;
	}
}
