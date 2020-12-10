<?php

namespace App\Controller;

use App\Cache\PictureCache;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @var PictureCache
     */
    private $pictureCache;

    public function __construct(PictureCache $pictureCache)
    {
        $this->pictureCache = $pictureCache;
    }

    /**
     * @Route("/",name="app_home")
     * @param PictureRepository $repository
     * @return Response
     */
    public function home(PictureRepository $repository): Response
    {
        $pictures = $repository->findNotNull("portfolio");
        return $this->render('front/show.html.twig', [
            'title' => 'Portfolio',
            'pictures' =>$pictures,
        ]);
    }

    /**
     * @Route("/images/{slug}", name="show")
     * @param PictureRepository $repository
     * @param string $slug
     * @return Response
     */
    public function index(PictureRepository $repository,$slug='portfolio'): Response
    {

        $pictures = $this->pictureCache->pageCache($slug,$slug.$_SERVER['APP_ENV'],259200);
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
