<?php

namespace Models;

use Database\Connection;

class Model {
	protected Connection $db;

	public function __construct(Connection $db) {
		$this->db = $db;
	}
}