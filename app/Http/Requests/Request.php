<?php

namespace Http\Requests;

use Validators\Validator;

class Request {
	private array $post;
	private array $get;
	private array $rules;

	public function setRules( array $rules ): void {
		$this->rules = $rules;
	}

	public function __construct() {
		$this->post = $_POST;
		$this->get = $_GET;
	}

	public function validate(): bool {
		return Validator::make($this->post, $this->rules);
	}

	public function all(): array {
		return $this->post;
	}

	public function getAll(): array{
		return $this->get;
	}

	public function getParam($key): string | int {
		return $this->get[$key]?? 0;
	}
}