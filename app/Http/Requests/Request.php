<?php

namespace Http\Requests;

use Validators\Validator;

class Request {
	private array $post;
	private array $get;
	private array $rules;
	private array $data;

	public function setRules( array $rules ): void {
		$this->rules = $rules;
	}
	public function __construct() {
		$this->post = $_POST;
		$this->get = $_GET;
		$this->data = $_REQUEST;
	}
	public function validate(): bool {
		return Validator::make($this->post, $this->rules);
	}
	public function all(): array {
		return $this->data;
	}
	public function postAll(): array{
		return $this->post;
	}
	public function getAll(): array{
		return $this->get;
	}
	public function getParam($key): string | int {
		return $this->get[$key]?? 0;
	}
	public function input($key , $default = null): mixed {
		return $this->post[$key] ?? $default;
	}
}