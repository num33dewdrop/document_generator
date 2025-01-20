<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Validators\Validator;

class Request {
	private array $post;
	private array $get;
	private array $rules;
	private array $data;
	private array $file;

	public function __construct() {
		$this->post = $_POST;
		$this->get = $_GET;
		$this->file = $_FILES;
		$this->data = $_REQUEST;
	}
	public function setRules( array $rules ): void {
		$this->rules = $rules;
	}
	public function validate(User | null $user = null): void {
		if( Validator::make($this->post, $this->rules, $user) ) {
			session()->remove('errors');
			session()->remove('old');
		}else {
			session()->put('errors', Validator::getErrors());
			session()->put('old', $this->postAll());
			redirect()->back();
		}
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
	public function fileAll(): array{
		$file = [];
		foreach ($this->file as $key => $value) {
			$file[$key] = $value === "" ? null : $value;
		}
		return $file;
	}
	public function getParam($key): string | int {
		return $this->get[$key]?? 0;
	}
	public function input($key , $default = null): mixed {
		return $this->post[$key] ?? $default;
	}
	public function file($key): array {
		return $this->file[$key];
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