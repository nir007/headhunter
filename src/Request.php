<?php

namespace nir007\HeadHunter;

use Zend\Diactoros\Uri;
use pdeans\Http\Client;
use Zend\Diactoros\Request as DiactorosRequest;

class Request
{
	const BASE_URL = 'https://api.hh.ru/';

	protected $client;
	protected $headers = [
		'UserAgent' => 'app (test@test.com)'
	];

	public function __construct($userAgent = null, $token = null)
	{
		$this->client = new Client(
			[
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_SSL_VERIFYHOST => 0,
			]
		);
		if ($userAgent) $this->setUserAgent($userAgent);
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
		return $this->execute($uri, 'GET');
	}
	/**
	 * @param string $uri
	 * @param array $params
	 * @return array|null
	 */
	public function post($uri, $params = [])
	{
		return $this->execute(
			$uri, 'POST', ['query' => $params]
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
			$uri, 'PUT', ['json' => $params]
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
		return $this->execute($uri, 'DELETE');
	}

	/**
	 * @param string $userAgent
	 * @return $this
	 */
	public function setUserAgent($userAgent)
	{
		$this->headers = ['UserAgent' => $userAgent];
		return $this;
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
	 * @param string $uri
	 * @param string $method
	 * @param array $options
	 * @return array|null
	 */
	protected function execute($uri, $method, array $options = [])
	{
		$request = (new DiactorosRequest($uri, $method, $options))
			->withUri(new Uri($uri))
			->withMethod($method)
			->withAddedHeader('Authorization', $this->headers['Authorization'])
			->withAddedHeader('User-Agent', $this->headers['UserAgent'])
			->withAddedHeader('Content-Type', 'application/json');

		$response = $this->client->sendRequest($request);

		return json_decode($response->getBody(), true);
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