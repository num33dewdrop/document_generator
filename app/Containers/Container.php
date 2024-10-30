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
	public function call(object $instance, string $method) {
		try {
			//ReflectionMethod クラスは メソッドについての情報を報告
			$reflectionMethod = new ReflectionMethod($instance, $method);
			//メソッドのパラメーターを取得
			$parameters = $reflectionMethod->getParameters();
			$dependencies = $this->resolveDependencies($parameters);
			//実行 $instanceメソッドを実行するオブジェクト $dependenciesメソッドに渡すパラメータを配列で指定
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
			//パラメーターの型を取得
			$type = $parameter->getType();
			//組み込みの型であるかを調べる
			if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
				//型の名前の文字列を取得し、インスタンス化して配列に格納
				$dependencies[] = $this->make($type->getName());
			} else {
				throw new ReflectionException("Cannot resolve parameter: {$parameter->getName()}");
			}
		}
		return $dependencies;
	}
}
