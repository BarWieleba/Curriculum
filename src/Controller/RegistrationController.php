<?php


namespace App\Controller;


use App\Entity\User;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/register", name="registration")
     * @param Request $request
     * @return Response
     */
    public function register(Request $request){
        if ($request->isXmlHttpRequest()){
            $userName = $request->request->get('username');
            $password = $request->request->get('password');
            if($this->validate($userName)){
                return new Response("Taki użytkownik już istnieje", 400);
            }
            $user = new User();
            $user->setUsername($userName);
            $user->setPassword($password);
            $passwordHash = $this->passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($passwordHash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return new Response("Zarejestrowano", 200);

        }
        return new Response("Not coming from ajax", 400);
    }
    private function validate($userName){
        $checkUser = $this->getDoctrine()->getRepository(User::class);
        return $checkUser->findBy(['username'=>$userName]) ? true : false;
    }

}