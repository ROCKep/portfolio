<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
//use AppBundle\Entity\Student;
//use AppBundle\Entity\Teacher;
use AppBundle\Entity\User;
use AppBundle\Form\SignupType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SignupController extends Controller
{
    /**
     * @Route("/signup", name="signup")
     */
    public function indexAction(Request $request)
    {
        $user = new User();
        $user->setRole($this->getDoctrine()
            ->getRepository("AppBundle:Role")
            ->findOneBy(array('role' => 'ROLE_USER')));
        $form = $this->createForm(SignupType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $root = new Category();
            $root->setName('Корень');
            $root->setUser($user);

            $em = $this->getDoctrine()->getManager();


            $em->persist($user);
            $em->persist($root);
            $em->flush();

            return $this->redirectToRoute('signup_success');
        }

        return $this->render('signup/index.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/signup/success", name="signup_success")
     */
    public function successAction()
    {
        return $this->render('signup/success.html.twig');
    }
}