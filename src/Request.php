<?php

namespace nir007\HeadHunter;

class Request
{
	const BASE_URL = 'https://api.hh.ru/';
	protected $headers = [];

	public function __construct($token = null)
	{
		if ($token) $this->setToken($token);
	}

	/**
	 * @param string $uri
	 * @param array $params
	 * @return array|null
	 */
	public function get($uri, $params = [])
	{
		$uri = $this->makeUriWithQuery($uri, $params);
		return $this->execute('GET', $uri);
	}
	/**
	 * @param string $uri
	 * @param array $params
	 * @return array|null
	 */
	public function post($uri, $params = [])
	{
		return $this->execute(
			'POST', $uri, ['query' => $params]
		);
	}

	/**
	 * @param string $uri
	 * @param array $params
	 * @return array|null
	 */
	public function putJson($uri, $params = [])
	{
		return $this->execute(
			'PUT', $uri, ['json' => $params]
		);
	}
	/**
	 * @param string $uri
	 * @param array $params
	 * @return array|null
	 */
	public function delete($uri, $params = [])
	{
		$uri = $this->makeUriWithQuery($uri, $params);
		return $this->execute('DELETE', $uri);
	}

	/**
	 * @param string $token
	 * @return $this
	 */
	public function setToken($token)
	{
		$this->headers = ['Authorization' => 'Bearer ' . $token];
		return $this;
	}

	/**
	 * @param string $uri
	 * @param array $params
	 * @return string
	 */
	protected function makeUriWithQuery($uri, array $params = [])
	{
		if (!empty($params)) {
			$uri .= '?' . $this->makeQueryString($params);
		}
		return $uri;
	}

	/**
	 * @param string $method
	 * @param string $uri
	 * @param array $options
	 * @return array|null
	 */
	protected function execute($method, $uri, array $options = [])
	{
		return json_decode("");
	}

	/**
	 * @param $params
	 * @return string
	 */
	protected function makeQueryString($params = [])
	{
		$params = array_merge(
			[
				'host'   => 'hh.ru',
				'locale' => 'ru',
			],
			$params
		);
		return http_build_query($params);
	}
}