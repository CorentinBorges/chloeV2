<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/{slug}", name="show")
     */
    public function index(PictureRepository $repository,$slug='portfolio')
    {
        $pictures = $repository->findNotNull($slug);
        if ($slug!=('portfolio'||"papier"||"numerique")) {
            throw $this->createNotFoundException("La page que vous cherchez n'existe pas");
        }

        return $this->render('front/show.html.twig', [
            'title' => ucfirst($slug),
            'pictures' =>$pictures,
        ]);
    }
}
