<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\Validation\UserValidator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends Controller {

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request) {
        if ($request->isMethod(Request::METHOD_POST)) {
            $username = $request->request->get('_username');
            $email = $request->request->get('_email');
            $password = $request->request->get('_password');

            $user = new User($username, $email, $password);
            $userValidator = new UserValidator($user);

            if (!$userValidator->validate()) {
                return $this->render('sign_up.html.twig', [
                    'error' => 'Invalid data'
                ]);
            }

            if ($this->getDoctrine()->getRepository('App:User')->findBy(['username' => $user->getUsername()], null, 1)) {
                return $this->render('sign_up.html.twig', [
                    'error' => 'Username is already used'
                ]);
            }

            if ($this->getDoctrine()->getRepository('App:User')->findBy(['email' => $user->getEmail()], null, 1)) {
                return $this->render('sign_up.html.twig', [
                    'error' => 'Email is already used'
                ]);
            }

            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
            $user->setIsAdmin(false);
            $user->setRegisteredAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->makeLogin($user);

            return $this->redirectToRoute('admin');
        }

        return $this->render('sign_up.html.twig');
    }

    private function makeLogin(User $user) {
        $token = new UsernamePasswordToken($user, $user->getPassword(), "public", $user->getRoles());
        $this->get("security.token_storage")->setToken($token);
    }
}