<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="security_login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){}

    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encodeur){
        $user= new User();
        $form = $this ->createForm(RegistrationType::class ,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $hash = $encodeur->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
