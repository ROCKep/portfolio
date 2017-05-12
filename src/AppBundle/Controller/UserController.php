<?php

namespace AppBundle\Controller;

use AppBundle\Form\AvatarType;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Form\InfoType;
use AppBundle\Form\SignupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route(path="/user/{id}", name="user_show", requirements={"id": "\d+"})
     */
    public function showAction($id = null)
    {
        if ($id === null)
        {
            if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
            {
                $this->denyAccessUnlessGranted('ROLE_USER');
            }
            $user = $this->getUser();
            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($id);
        if (!$user)
        {
            throw $this->createNotFoundException("Пользователя с таким id не существует");
        }
        if ($user->getRole()->getRole() == 'ROLE_ADMIN')
        {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        return $this->render('user/show.html.twig', array('user' => $user));
    }

    /**
     * @Route(path="/edit/{str}", name="user_edit")
     */
    public function editAction(Request $request, $str = null)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $this->denyAccessUnlessGranted('ROLE_USER');
        }
        $user = $this->getUser();
        switch ($str)
        {
            case null:
                $form = $this->createForm(InfoType::class, $user);
                break;
            case 'security':
                $form = $this->createForm(ChangePasswordType::class, $user);
                break;
            case 'avatar':
                $form = $this->createForm(AvatarType::class, $user);
                break;
            default:
                return $this->createNotFoundException();
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if ($user->getPlainPassword() != null)
            {
                $password = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Изменения сохранены');
            return $this->redirectToRoute('user_edit');
        }

        switch ($str)
        {
            case null:
                return $this->render('user/edit/main.html.twig', array('form' => $form->createView()));
            case 'security':
                return $this->render('user/edit/security.html.twig', array('form' => $form->createView()));
            case 'avatar':
                return $this->render('user/edit/avatar.html.twig', array('user' =>$user,
                    'form' => $form->createView()));
        }
    }
}