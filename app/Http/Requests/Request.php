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

	public function appendGetParam($arr_del_key = array(), $arr_in = array()): string {
		$str = '?';
		if( ! empty( $arr_in ) ) {
			foreach ( $arr_in as $key => $val ) {
				$str .= $key . '=' . $val . '&';
			}
		}
		if ( ! empty( $this->get ) ) {
			foreach ( $this->get as $key => $val ) {
				if ( ! in_array( $key, $arr_del_key, true ) ) {
					$str .= $key . '=' . $val . '&';
				}
			}
		}
		return  mb_substr( $str, 0, - 1, "UTF-8" );
	}
}