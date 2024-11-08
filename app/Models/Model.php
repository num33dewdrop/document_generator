<?php

namespace Models;

use Database\Connection;
use Utilities\Paginator;

class Model {
	protected Connection $db;
	protected Paginator $paginator;

	public function __construct(Connection $db, Paginator $paginator) {
		$this->db = $db;
		$this->paginator = $paginator;
	}

	public function getDatabase(): Connection {
		return $this->db;
	}
}