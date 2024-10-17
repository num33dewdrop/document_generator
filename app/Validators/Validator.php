<?php

namespace Validators;

use Database\Connection;
use Model\User;

class Validator {
	private static array $errors;
	protected static User $user;

	public static function setUser(User $user): void {
		self::$user = $user;
	}
	public static function make(array $data, array $rules): bool {
		foreach ($rules as $field => $ruleSet) {
			$value = $data[$field] ?? null;
			foreach ($ruleSet as $rule) {
				switch ($rule) {
					case 'required':
						if(empty($value)) {
							self::$errors[$field][] = "{$field} is required.";
						}
						break;
					case 'email':
						if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
							self::$errors[$field][] = "{$field} must be a valid email address.";
						}
						if(self::$user?->findByEmail($value)) {
							self::$errors[$field][] = "{$field} must be a non-duplicate email address.";
						}
						break;
				}
			}
		}
		return empty(self::$errors);
	}

	public static function getErrors(): array {
		return self::$errors;
	}
}