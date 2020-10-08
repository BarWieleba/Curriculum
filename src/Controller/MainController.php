<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="mainPage")
     */
    public function mainPage(AuthenticationUtils $authenticationUtils){
        $token = $this->get('security.token_storage')->getToken()->getUser();
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('index.html.twig', array('user'=>$token, 'last_username' => $lastUsername, 'error' => $error));
    }
}