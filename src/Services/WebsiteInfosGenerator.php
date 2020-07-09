<?php


namespace App\Services;


use App\Repository\UserRepository;
use App\Repository\WebsiteInfosRepository;

class WebsiteInfosGenerator
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    private $infos;

    public function __construct(WebsiteInfosRepository $websiteInfosRepository)
    {
        $this->infos=$websiteInfosRepository->find($websiteInfosRepository->maxId('App:WebsiteInfos'));
    }

    public function getInstagram()
    {
        return $this->infos->getInstagram();
    }

    public function getMail()
    {

        return $this->infos->getMail();
    }

}