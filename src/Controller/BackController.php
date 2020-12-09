<?php

namespace App\Controller;

use App\Cache\PictureCache;
use App\DTO\Pictures\EditPictureDTO;
use App\Entity\User;
use App\Form\AddPicsType;
use App\Form\EditPicsFormType;
use App\Form\ImageFormType;
use App\Form\UserFormType;
use App\Form\WebInfosFormType;
use App\Helper\Pics\AddPicsHelper;
use App\Helper\ViolationHelper;
use App\Repository\PictureRepository;
use App\Repository\UserRepository;
use App\Repository\WebsiteInfosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Provider\Image;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class BackController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class BackController extends BaseController
{

    /**
     * @var PictureCache
     */
    private $pictureCache;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var PictureRepository
     */
    private $pictureRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        PictureCache $pictureCache,
        ValidatorInterface $validator,
        PictureRepository $pictureRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
        $this->pictureCache = $pictureCache;
        $this->validator = $validator;
        $this->pictureRepository = $pictureRepository;
    }


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

        $userForm = $this->createForm(UserFormType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && !($userForm->isValid())) {
            $this->addFlash('error','Aïe, il y à une erreur dans le nom ou le mot de passe!');
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

        $infos = $infosRepository->find($infosRepository->maxId('App:WebsiteInfos'));
        $infoForm = $this->createForm(WebInfosFormType::class,$infos);
        $infoForm->handleRequest($request);
        if ($infoForm->isSubmitted() && $infoForm->getErrors()) {
            $this->addFlash('error','Aïe, les données n\'ont pu être modifiées!');

        }

        if ($infoForm->isSubmitted() && $infoForm->isValid()) {
            $infos = $infoForm->getData();

            $em->persist($infos);
            $em->flush();
            $this->addFlash('success','Bravo!!! Vous avez admirablement modifié votre site!');
        }


        return $this->render('back/editLogs.html.twig',[
            'userForm' => $userForm->createView(),
            'infosForm' => $infoForm->createView(),
        ]);
    }

    /**
     * @Route("/admin/order/{page<papier|portfolio|numerique>}",name="app_order")
     */
    public function changeOrder($page,PictureRepository $pictureRepository,Request $request,EntityManagerInterface $entityManager)
    {
        if ($request->isMethod('post')) {

            foreach ($request->request->all() as $id => $pageId) {

                $picture = $pictureRepository->find($id);
                switch ($page) {
                    case 'papier':
                        $picture->setPapier($pageId);
                        break;
                    case 'portfolio':
                        $picture->setPortfolio($pageId);
                        break;
                    case 'numerique':
                        $picture->setNumerique($pageId);
                }
                $entityManager->persist($picture);
                $entityManager->flush();

            };
        }

        $pictures = $pictureRepository->findNotNull($page);
        return $this->render('back/order.html.twig', [
            'title' => ucfirst($page),
            'pictures' =>$pictures,
        ]);
    }

    /**
     * @Route("/admin/editPictures", name="edit_pics")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editPics(Request $request)
    {
        $form = $this->createForm(ImageFormType::class, null,['is_edit' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $picPDO = new EditPictureDTO($form->getData(), $this->pictureRepository);
            $errors=$this->validator->validate($picPDO);
            if ($errors->count() > 0) {
                $listError = ViolationHelper::build($errors);
                throw new \InvalidArgumentException($listError);
            }

            $picture = $this->pictureRepository->find($form->getData()['id']);

            $picture->editPicture($picPDO);
            $this->entityManager->flush();
            $this->pictureCache->deleteCache('allPics');
        }

        $pictures=$this->pictureCache->allPicsCache('allPics',3600);
        return $this->render('back/editPics.html.twig',[
            'title' => 'Éditer',
            'pictures' => $pictures,
            'pictureForm' => $form
        ]);
    }

    /**
     * @Route("/admin/addPictures", name="add_pics")
     * @param Request $request
     * @param AddPicsHelper $addPicsHelper
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addPics(Request $request, AddPicsHelper $addPicsHelper)
    {
        $form = $this->createForm(AddPicsType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $addPicsHelper->imageCreator($form->get('images'),$this->validator);
        }

        return $this->render('back/addPics.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
