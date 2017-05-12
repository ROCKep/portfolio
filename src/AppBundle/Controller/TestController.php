<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route as Route;

class TestController extends Controller
{
    /**
     * @Route(path="/test")
     */
    public function indexAction()
    {
        return new Response("");
    }

}
