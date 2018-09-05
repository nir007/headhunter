<?php

namespace nir007\HeadHunter;

class HeadHunterApi {

	private $_request;

	public function __construct($token, $userAgent = null)
	{
		$this->_request = (new Request())
			->setToken($token)
			->setUserAgent($userAgent);
	}

	/**
	 * @param $id
	 * @return array|null
	 */
	public function findVacancyById($id)
	{
		return $this->_request->get('vacancies/' . $id, [
			'vacancy_id ' => $id
		]);
	}

	/**
	 * @param $findString
	 * @param int $page
	 * @param int $per_page
	 * @return array|null
	 */
	public function findVacancies($findString, $page = 0, $per_page = 10)
	{
		return $this->_request->get('vacancies', [
			'text' => $findString,
			'page' => $page,
			'per_page' => $per_page
		]);
	}

	/**
	 * @param $findString
	 * @param int $page
	 * @param int $per_page
	 * @return array|null
	 */
	public function findEmployers($findString, $page = 0, $per_page = 10)
	{
		return $this->_request->get('employers', [
			'text' => $findString,
			'page' => $page,
			'per_page' => $per_page
		]);
	}

}