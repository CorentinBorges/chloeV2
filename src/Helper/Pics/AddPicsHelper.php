<?php


namespace App\Helper\Pics;


use App\DTO\Pictures\AddPictureDTO;
use App\Entity\Picture;
use App\Helper\ViolationHelper;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddPicsHelper
{

    /**
     * @var FileUploader
     */
    private $fileUploader;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;
    /**
     * @var PictureRepository
     */
    private $pictureRepository;

    public function __construct(
        FileUploader $fileUploader,
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag,
        PictureRepository $pictureRepository
    )
    {
        $this->fileUploader = $fileUploader;
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
        $this->pictureRepository = $pictureRepository;
    }

    public function imageCreator(FormInterface $images, ValidatorInterface $validator)
    {
        foreach ($images as $image) {

            $imageFile = $image->get('image')->getData();
            $imageFileName = $this->fileUploader->upload($imageFile);
            /** @var Picture $pictureEntity */
            $pictureEntityDTO = new AddPictureDTO( $image->getData(), $this->pictureRepository,$imageFileName);
            // todo: continue here

            $errors = $validator->validate($pictureEntityDTO);
            if ($errors->count() > 0) {
                $listError = ViolationHelper::build($errors);
                throw new \InvalidArgumentException($listError);
            }
            $pictureEntity = Picture::addPicture($pictureEntityDTO);
            $this->entityManager->persist($pictureEntity);
        }
        $this->entityManager->flush();
        $this->flashBag->add("success", "La ou même les images ont été... AJOUTÉ!!! 🚀 ");
    }
}