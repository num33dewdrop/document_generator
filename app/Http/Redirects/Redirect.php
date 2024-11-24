<?php

namespace Http\Redirects;

use Utilities\Debug;

class Redirect
{
	protected string $url;
	protected int $statusCode;
	protected array $headers;

	public function __construct(string $url = '', int $statusCode = 302, array $headers = [])
	{
		$this->url = $url;
		$this->statusCode = $statusCode;
		$this->headers = $headers;
	}

	public function to(string $url): self
	{
		$this->url = $url;
		return $this;
	}

	public function route(string $name, array $params = []): void
	{
		$url = route($name);

		if (!empty($params)) {
			//URL エンコードされたクエリ文字列を生成
			$query = http_build_query($params);
			$url .= '?' . $query;
		}

		$this->to($url)->send();
	}

	public function carry( array $with): self {
		foreach ($with as $key => $value){
			session()->flash($key, $value);
		}
		return $this;
	}

	public function back(): void
	{
		$referer = $_SERVER['HTTP_REFERER'] ?? '/';
		$this->to($referer)->send();
	}

	public function send(): void
	{
		// ヘッダーを追加
		foreach ($this->headers as $key => $value) {
			header("$key: $value");
		}

		header('Location: ' . $this->url, true, $this->statusCode);
		exit;
	}
}