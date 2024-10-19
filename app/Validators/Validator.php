<?php

namespace Validators;

use Database\Connection;
use Models\User;

class Validator {
	private static array $errors;
	protected static array $messages;
	protected static array $posts;

	public static function make(array $posts, array $rules, Connection $db): bool {
		self::$messages = require base_path('config/validation.php');
		self::$posts = $posts;
		foreach ($rules as $field => $ruleSet) {
			$value = $posts[$field] ?? null;
			foreach (explode('|', $ruleSet) as $rule) {
				self::validateRule($field, $value, $rule, $db);
			}
		}
		return empty(self::$errors);
	}

	private static function validateRule(string $field, $value, string $rule, $db): void {
		var_dump($value);
		switch (trim($rule)) {
			case 'required':
				if (empty($value)) {
					self::addError($field, 'required');
				}
				break;
			case 'email':
				$user = new User($db);
				if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
					self::addError($field, 'email');
				}
				if ($user->findByEmail($value)) {
					self::addError($field, 'duplicate');
				}
				break;
			case (bool) preg_match( '/^max:(\d+)$/', $rule, $matches ):
				$max = (int)$matches[1];
				if (strlen($value) > $max) {
					self::addError($field, 'max', [':max' => $max]);
				}
				break;
			case (bool) preg_match( '/^min:(\d+)$/', $rule, $matches ):
				$min = (int)$matches[1];
				if (strlen($value) < $min) {
					self::addError($field, 'min', [':min' => $min]);
				}
				break;
			case (bool) preg_match( '/^same:(.+)$/', $rule, $matches ):
				$otherField = trim($matches[1]); // 再入力フィールドの名前を取得
				if ($otherField && $value !== (self::$posts[$otherField] ?? null)) {
					self::addError($field, 'same', [':other' => $otherField]);
				}
				break;
		}
	}

	private static function addError(string $field, string $rule, array $replace = []): void {
		$message = self::$messages[$rule] ?? 'Validation error.';
		$otherField = $replace[':other'];
		$message = str_replace(':other', self::$messages['attributes'][$otherField] ?? $otherField, $message);
		$message = str_replace(':attribute', self::$messages['attributes'][$field] ?? $field, $message);

		foreach ($replace as $key => $value) {
			$message = str_replace($key, $value, $message);
		}

		self::$errors[$field][] = $message;
	}

	public static function getErrors(): array {
		return self::$errors;
	}
}