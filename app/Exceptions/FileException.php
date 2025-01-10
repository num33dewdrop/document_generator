<?php

namespace Exceptions;

use Exception;
use RuntimeException;

class FileException extends RuntimeException {
	public function __construct($message, $code = 200){
		parent::__construct($message, $code);
	}
}