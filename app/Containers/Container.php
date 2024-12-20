<?php
namespace Containers;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionNamedType;
use Utilities\Debug;

class Container {

	/**
	 * @throws ReflectionException
	 */
	public function make(string $class) {
		try {
			//依存解決してインスタンス化
			//ReflectionClass クラスは クラスについての情報を報告
			//リフレクションとは、クラスやメソッドなどの構造をデータとして扱うことができる機能
			$reflectionClass = new ReflectionClass($class);
			//クラスのコンストラクタを取得
			$constructor = $reflectionClass->getConstructor();
			//コンストラクタがなければそのままインスタンス化
			if (is_null($constructor)) {
				return new $class();
			}
			//コンストラクターのパラメーターを取得
			$parameters = $constructor->getParameters();
			$dependencies = $this->resolveDependencies($parameters);
			//指定した引数（配列）でクラスの新しいインスタンスを作成
			//クラスの新しいインスタンスを返す
			return $reflectionClass->newInstanceArgs($dependencies);
		} catch (ReflectionException $e) {
			throw new ReflectionException("Failed to instantiate class: " . $e->getMessage());
		}
	}

	/**
	 * @throws ReflectionException
	 */
	public function call(array $callable, array $params) {
		try {
			// 配列の形式でインスタンスとメソッドを取得
			[$instance, $method] = $callable;
			//ReflectionMethod クラスは メソッドについての情報を報告
			$reflectionMethod = new ReflectionMethod($instance, $method);
			//メソッドのパラメーターを取得
			$parameters = $reflectionMethod->getParameters();
			$dependencies = $this->resolveDependencies($parameters, $params);
			//実行 $instanceメソッドを実行するオブジェクト $dependenciesメソッドに渡すパラメータを配列で指定
			return $reflectionMethod->invokeArgs($instance, $dependencies);
		} catch (ReflectionException $e) {
			throw new ReflectionException("Failed to call method: " . $e->getMessage());
		}
	}

	/**
	 * @throws ReflectionException
	 */
	protected function resolveDependencies(array $parameters, array $params = []): array {
		$dependencies = [];
		foreach ($parameters as $parameter) {
			$name = $parameter->getName();
			$type = $parameter->getType();

			if (!empty($params) && array_key_exists($name, $params)) {
				if ($type instanceof ReflectionNamedType) {
					// 型チェック: 組み込み型かつ型が一致しない場合
					$expectedType = $type->getName();
					if ($type->isBuiltin() && gettype($params[$name]) !== $expectedType) {
						throw new ReflectionException(
							"Invalid type for parameter '{$name}'. Expected '{$expectedType}', got '" . gettype($params[$name]) . "'."
						);
					}
				}
				// `$params` に指定されている場合はその値を使用
				$dependencies[] = $params[$name];
				continue;
			}

			//組み込みの型であるかを調べる
			if ($type instanceof ReflectionNamedType) {
				if ($type->isBuiltin()) {
					// デフォルト値がある場合はそれを使用
					if ($parameter->isDefaultValueAvailable()) {
						$dependencies[] = $parameter->getDefaultValue();

					} else {
						throw new ReflectionException("Missing value for parameter: {$name}");
					}
				}else {
					// 非組み込み型は依存解決を試みる
					$dependencies[] = $this->make($type->getName());
				}
			} else {
				throw new ReflectionException("Cannot resolve parameter: {$parameter->getName()}");
			}
		}
		return $dependencies;
	}
}
