<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('sign_in.html.twig', array(
            'error' => $error,
            'last_username' => $lastUsername,
        ));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheck() {}

    /**
     * @Route("/logout", name="logout")
     */
    public function logout() {}
}