<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route(path="/admin", name="admin_panel")
     */
    public function indexAction()
    {
        return $this->render('admin/index.html.twig');
    }
}
