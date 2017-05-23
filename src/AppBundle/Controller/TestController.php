<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Account;
use AppBundle\Entity\File;
use AppBundle\Entity\Photo;
use AppBundle\Entity\Test;
use AppBundle\Form\PhotoType;
use AppBundle\Form\TestType;
use AppBundle\Form\UploadFileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route as Route;

class TestController extends Controller
{
    /**
     * @Route(path="/test")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('homepage');
    }

}
