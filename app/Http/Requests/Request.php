<?php

namespace Http\Requests;

use Utilities\Debug;
use Validators\Validator;

class Request {
	private array $post;
	private array $get;
	private array $rules;
	private array $data;

	public function __construct() {
		$this->post = $_POST;
		$this->get = $_GET;
		$this->data = $_REQUEST;
	}
	public function setRules( array $rules ): void {
		$this->rules = $rules;
	}
	public function validate(): bool {
		return Validator::make($this->post, $this->rules);
	}
	public function all(): array {
		return $this->data;
	}
	public function postAll(): array{
		$post = [];
		foreach ($this->post as $key => $value) {
			$post[$key] = $value === "" ? null : $value;
		}
		return $post;
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

	public function method(): string {
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method === 'POST' && $this->input( '_method' ) !== null ) {
			$method = strtoupper($this->input( '_method' ));
		}
		if($this->header('X-Method-Override') !== null) {
			$method = $this->header('X-Method-Override');
		}
		return $method;
	}

	public function header($key)
	{
		$headerKey = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
		return $_SERVER[$headerKey] ?? null;
	}
}