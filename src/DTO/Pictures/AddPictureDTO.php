<?php


namespace App\DTO\Pictures;


use App\Repository\PictureRepository;
use Symfony\Component\Validator\Constraints as Assert;

class AddPictureDTO extends AbstractPictureDTO
{
    public $fileName;

    public function __construct(array $formDatas,PictureRepository $repository,string $fileName){
        parent::__construct($formDatas, $repository);
        $this->fileName = $fileName;
    }
}