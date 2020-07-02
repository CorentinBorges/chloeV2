<?php

namespace App\Controller;

use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/",name="app_home")
     */
    public function home(PictureRepository $repository)
    {
        $pictures = $repository->findNotNull("portfolio");
        return $this->render('front/show.html.twig', [
            'title' => 'Portfolio',
            'pictures' =>$pictures,
        ]);
    }

    /**
     * @Route("/images/{slug}", name="show")
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

    /**
     * @Route("/contact",name="app_contact")
     */
    public function contact()
    {
        return $this->render('front/contacts.html.twig');
    }

    /**
     * @Route("/a_propos",name="app_about")
     */
    public function about()
    {
        return $this->render("front/about.html.twig");
    }
}
