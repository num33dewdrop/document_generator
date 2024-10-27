<?php
namespace Containers;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionNamedType;

class Container {
	/**
	 * @throws ReflectionException
	 */
	public function make(string $class) {
		try {
			$reflectionClass = new ReflectionClass($class);
			$constructor = $reflectionClass->getConstructor();

			if (is_null($constructor)) {
				return new $class();
			}

			$parameters = $constructor->getParameters();
			$dependencies = $this->resolveDependencies($parameters);

			return $reflectionClass->newInstanceArgs($dependencies);
		} catch (ReflectionException $e) {
			throw new ReflectionException("Failed to instantiate class: " . $e->getMessage());
		}
	}

	/**
	 * @throws ReflectionException
	 */
	public function call(object $instance, string $method) {
		try {
			$reflectionMethod = new ReflectionMethod($instance, $method);
			$parameters = $reflectionMethod->getParameters();
			$dependencies = $this->resolveDependencies($parameters);

			return $reflectionMethod->invokeArgs($instance, $dependencies);
		} catch (ReflectionException $e) {
			throw new ReflectionException("Failed to call method: " . $e->getMessage());
		}
	}

	/**
	 * @throws ReflectionException
	 */
	protected function resolveDependencies(array $parameters): array {
		$dependencies = [];
		foreach ($parameters as $parameter) {
			$type = $parameter->getType();
			if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
				$dependencies[] = $this->make($type->getName());
			} else {
				throw new ReflectionException("Cannot resolve parameter: {$parameter->getName()}");
			}
		}
		return $dependencies;
	}
}
