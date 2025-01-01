<?php

namespace Models;

use Database\Connection;
use PDO;
use Utilities\Paginator;

class Model {
	protected Paginator $paginator;

	public function __construct(Paginator $paginator) {
		Connection::setup();
		$this->paginator = $paginator;
	}
}