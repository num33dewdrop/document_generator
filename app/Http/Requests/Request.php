<?php

namespace Http\Requests;

use Database\Connection;
use Validators\Validator;

class Request {
	protected array $data;
	protected array $rules;
	protected Connection $db;

	public function __construct(array $data, array $rules, Connection $db) {
		$this->data = $data;
		$this->rules = $rules;
		$this->db = $db;
	}

	public function validate(): bool {
		return Validator::make($this->data, $this->rules, $this->db);
	}

	public function all(): array {
		return $this->data;
	}
}