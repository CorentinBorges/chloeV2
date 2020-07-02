<?php


namespace App\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/admin",name="app_admin")
     */
    public function loginAdmin(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUserName = $authenticationUtils->getLastUsername();

        return $this->render("security/login.html.twig", [
            'last_username' => $lastUserName,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout",name="app_logout")
     */
    public function logout()
    {
        
    }
}