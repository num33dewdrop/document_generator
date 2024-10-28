<?php

namespace Http\Middleware;

use Closure;

interface MiddlewareInterface {
	//オブジェクト インターフェイスを使うと、メソッドの実装を定義せずに、
	//クラスが実装する必要があるメソッドを指定するコードを作成できる
	//メソッドの実装は全く定義しない
	//interfaceをinterfaceが継承することもできる
	public function handle(Closure $next);
}