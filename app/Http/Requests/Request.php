<?php

namespace Http\Requests;

use Database\Connection;
use Validators\Validator;

class Request {
	private array $post;
	private array $get;
	private array $rules;
	private Connection $db;

	public function setRules( array $rules ): void {
		$this->rules = $rules;
	}

	public function __construct(Connection $db) {
		$this->post = $_POST;
		$this->get = $_GET;
		$this->db = $db;
	}

	public function validate(): bool {
		return Validator::make($this->post, $this->rules, $this->db);
	}

	public function all(): array {
		return $this->post;
	}

	public function getParam($key): string | int {
		return $this->get[$key]?? 0;
	}
}