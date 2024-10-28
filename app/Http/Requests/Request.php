<?php

namespace Http\Requests;

use Database\Connection;
use Validators\Validator;

class Request {
	protected array $data;
	protected array $rules;
	protected Connection $db;

	public function setRules( array $rules ): void {
		$this->rules = $rules;
	}

	public function __construct(Connection $db) {
		$this->data = $_POST;
		$this->db = $db;
	}

	public function validate(): bool {
		return Validator::make($this->data, $this->rules, $this->db);
	}

	public function all(): array {
		return $this->data;
	}
}