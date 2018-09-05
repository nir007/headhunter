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

    public function getVacancy($id)
    {
        return $this->_request->get('vacancies', [
            'vacancy_id' => $id
        ]);
    }

}