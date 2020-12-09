<?php


namespace App\DTO\Pictures;


use App\Repository\PictureRepository;
use Symfony\Component\Validator\Constraints as Assert;

class EditPictureDTO extends AbstractPictureDTO
{
    public $id;

    public $fileName;

    public function __construct(array $formDatas,PictureRepository $repository){
        parent::__construct($formDatas, $repository);
        $this->id = $formDatas['id'];
        $picToEdit = $repository->find($this->id);
        $this->fileName = $picToEdit->getFileName();
    }
}