<?php


namespace App\DTO\Pictures;


use App\Repository\PictureRepository;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractPictureDTO
{

    /**
     * @Assert\Type(type="string", message="Le titre doit comporter une chaîne de caractère")
     */
    public $title;

    /**
     * @Assert\Type(type="string", message="La description doit comporter une chaîne de caractère")
     */
    public $alt;

    /**
     * @Assert\Type(type="integer")
     */
    public $portfolio = null;

    /**
     * @Assert\Type(type="integer")
     */
    public $papier = null;

    /**
     * @Assert\Type(type="integer")
     */
    public $numerique = null;

    public function __construct(array $formDatas, PictureRepository $repository)
    {
        $this->title = $formDatas['picName'];
        $this->alt = $formDatas['description'];
        if ($formDatas['portfolio'] === true) {
            $this->portfolio = $repository->findMax('portfolio') + 1;
        }
        else{
            $this->portfolio = null;
        }
        if ($formDatas['papier'] === true) {
            $this->papier = $repository->findMax('papier') + 1;
        }
        else{
            $this->papier = null;
        }
        if ($formDatas['numerique'] === true) {
            $this->numerique = $repository->findMax('numerique') + 1;
        }
        else{
            $this->numerique = null;
        }
    }
}