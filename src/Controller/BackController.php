<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Form\WebInfosFormType;
use App\Repository\PictureRepository;
use App\Repository\UserRepository;
use App\Repository\WebsiteInfosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class BackController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class BackController extends BaseController
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

    /**
     * @Route("/admin/editLogs",name="app_editLogs")
     * @param Request $request
     * @param PasswordEncoderInterface $passwordEncoder
     * @param WebsiteInfosRepository $infosRepository
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editLogs(UserRepository $userRepository,Request $request,UserPasswordEncoderInterface $passwordEncoder,WebsiteInfosRepository $infosRepository,EntityManagerInterface $em)
    {
        $user = new User();
        $admin = $userRepository->find($userRepository->maxId('App:User'));

        $infos = $infosRepository->find($infosRepository->maxId('App:WebsiteInfos'));
        $infoForm = $this->createForm(WebInfosFormType::class,$infos);
        $infoForm->handleRequest($request);
        if ($infoForm->isSubmitted() && $infoForm->getErrors()) {
            $this->addFlash('error','Aïe, les données n\'ont pu être modifiées!');

        }

        $userForm = $this->createForm(UserFormType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && !($userForm->isValid())) {
            $this->addFlash('error','Aïe, il y à une erreur dans le nom ou le mot de passe!');
        }

        if ($infoForm->isSubmitted() && $infoForm->isValid()) {
            $infos = $infoForm->getData();

            $em->persist($infos);
            $em->flush();
            $this->addFlash('success','Bravo!!! Vous avez admirablement modifié votre site!');
        }
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $admin->setUsername($userForm['username']->getData());
            if ($userForm['plainPassword']->getData() && !empty($userForm['plainPassword']->getData())) {
                $admin->setPassword($passwordEncoder->encodePassword($user, $userForm['plainPassword']->getData()));
            }


            $em->persist($admin);
            $em->flush();
            $this->addFlash('success','Bravo!!! Vous avez admirablement modifié vos données d\'utilisatrice!');

        }

        return $this->render('back/editLogs.html.twig',[
            'userForm' => $userForm->createView(),
            'infosForm' => $infoForm->createView(),
        ]);
    }

    /**
     * @Route("/admin/order/{page<papier|portfolio|numerique>}",name="app_order")
     */
    public function changeOrder($page,PictureRepository $pictureRepository)
    {

        $pictures = $pictureRepository->findNotNull($page);
        return $this->render('back/order.html.twig', [
            'title' => ucfirst($page),
            'pictures' =>$pictures,
        ]);

    }
}
