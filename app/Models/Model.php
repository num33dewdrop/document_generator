<?php

namespace App\Models;

use App\Database\Connection;
use PDO;
use App\Utilities\Paginator;

class Model {
	protected Paginator $paginator;

	public function __construct(Paginator $paginator) {
		Connection::setup();
		$this->paginator = $paginator;
	}
}