<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/welcome", name="welcome")
     */
    public function welcome() {
        return $this->render('admin/welcome.html.twig');
    }
}