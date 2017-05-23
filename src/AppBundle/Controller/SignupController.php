<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Student;
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
        $student = new Student();

        $form = $this->createForm(SignupType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $student->setSignupDate();

            $account = $student->getAccount();
            $password = $this->get('security.password_encoder')
                ->encodePassword($account, $account->getPlainPassword());
            $account->setPassword($password);

            $role = $this->getDoctrine()->getRepository('AppBundle:Role')
                ->findOneBy(array('name' => 'ROLE_USER'));
            $account->setRole($role);

            $root = new Category();
            $root->setName($student->getFirstName() . ' ' . $student->getLastName());
            $root->setCreatedDate();
            $root->setStudent($student);

            $em = $this->getDoctrine()->getManager();

            $em->persist($account);
            $em->persist($student);
            $em->persist($root);
            $em->flush();

            $this->addFlash('success', 'Регистрация прошла успешно');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('signup/index.html.twig', array('form' => $form->createView()));
    }
}