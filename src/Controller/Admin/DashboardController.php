<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends BaseAdminController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard() {
        return $this->render('admin/dashboard.html.twig');
    }
}