<?php

namespace App\Controller;

use App\Repository\PictureRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class BackController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class BackController extends AbstractController
{
    /**
     * @Route("/admin/home", name="app_admin_home")
     */
    public function index(PictureRepository $pictureRepository)
    {
        $cat = ["portfolio", "numerique", "papier"];
        $count = [];

        foreach ($cat as $value) {
            $count[$value] = $pictureRepository->count($value);
        }


        return $this->render('back/index.html.twig', [
            'title' => 'Bonjour '.$this->getUser()->getUsername(),
            'all' => $pictureRepository->count(),
            'count' => $count,
        ]);
    }
}
