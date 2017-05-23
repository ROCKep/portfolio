<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Community;
use AppBundle\Entity\Membership;
use AppBundle\Entity\Photo;
use AppBundle\Form\ChangePhotoType;
use AppBundle\Form\CommunityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommunityController extends Controller
{
    /**
     * @Route(path="/community/new", name="community_new")
     */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        $student = $this->getUser()->getStudent();

        $community = new Community();
        $community->setCreator($student);

        $form = $this->createForm(CommunityType::class, $community);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $community->setCreationDate();

            $membership = new Membership();
            $membership->setStudent($student);
            $membership->setCommunity($community);
            $membership->setEntryDate();

            $category = new Category();
            $category->setCommunity($community);
            $category->setName($community->getName());
            $category->setCreatedDate();

            $em = $this->getDoctrine()->getManager();
            $em->persist($community);
            $em->persist($membership);
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('community_show', array('id' => $community->getId()));
        }

        return $this->render('community/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(path="/community/{id}", name="community_show")
     */
    public function showAction($id)
    {
        $community = $this->getDoctrine()->getRepository('AppBundle:Community')
            ->getAllInfoAboutCommunity($id);
        if (!$community)
        {
            throw $this->createNotFoundException('Сообщества с таким id не существует');
        }

        $members = $this->getDoctrine()->getRepository('AppBundle:Student')->getMembersOfCommunity($id);

        $root_category = $this->getDoctrine()->getRepository('AppBundle:Category')
            ->getRootByCommunityId($id);

        return $this->render('community/show.html.twig', array(
            'community' => $community,
            'members' => $members,
            'root_category' => $root_category
        ));
    }

    /**
     * @Route(path="/community/{id}/edit", name="community_edit")
     */
    public function editAction(Request $request, $id)
    {
        $community = $this->getDoctrine()->getRepository('AppBundle:Community')->find($id);
        if (!$community)
        {
            throw $this->createNotFoundException('Сообщества с таким id не существует');
        }

        if($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_USER') && $this->getUser()->getStudent() === $community->getCreator()) {

            $form = $this->createForm(CommunityType::class, $community);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $this->addFlash('success', 'Изменения успешно сохранены');
                return $this->redirectToRoute('community_show', array('id' => $id));
            }

            return $this->render('community/edit/main.html.twig', array('community' => $community, 'form' => $form->createView()));
        }
        else {
            throw $this->createAccessDeniedException();
        }
    }

    /**
     * @Route(path="/community/{id}/edit/avatar", name="community_edit_avatar")
     */
    public function changePhotoAction(Request $request, $id)
    {
        $community = $this->getDoctrine()->getRepository('AppBundle:Community')->find($id);
        if (!$community)
        {
            throw $this->createNotFoundException('Сообщества с таким id не существует');
        }

        if($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_USER') && $this->getUser()->getStudent() === $community->getCreator()) {

            $form = $this->createForm(ChangePhotoType::class, $community);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $photo = new Photo();
                $photo->setOriginal($form->get('photoFile')->getData());
                $community->setPhoto($photo);
                $em = $this->getDoctrine()->getManager();
                $em->persist($community);
                $em->flush();

                $this->addFlash('success', 'Изменения сохранены');
                return $this->redirectToRoute('community_edit', array('id' => $id));
            }

            return $this->render('community/edit/photo.html.twig', array('community' => $community, 'form' => $form->createView()));
        }
        else {
            throw $this->createAccessDeniedException();
        }
    }

    /**
     * @Route(path="/community/{id}/delete", name="community_delete")
     */
    public function deleteAction($id)
    {
        $community = $this->getDoctrine()->getRepository('AppBundle:Community')->find($id);
        if (!$community)
        {
            throw $this->createNotFoundException('Сообщества с таким id не существует');
        }
        if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_USER') && $this->getUser()->getStudent() === $community->getCreator()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($community);
            $em->flush();

            return $this->redirectToRoute('student_show', array('id' => $community->getCreator()->getId()));
        }
        else {
            throw $this->createAccessDeniedException();
        }
    }

    /**
     * @Route(path="/community/{id}/enter", name="community_enter")
     */
    public function enterAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $student = $this->getUser()->getStudent();

        $community = $this->getDoctrine()->getRepository('AppBundle:Community')->getCommunityWithMembers($id);
        if (!$community)
        {
            throw $this->createNotFoundException('Сообщества с таким id не существует');
        }

        foreach($community->getMemberships() as $membership)
        {
            if ($student === $membership->getStudent())
            {
                $this->addFlash('warning', 'Вы уже вступили в данное сообщество.');
                return $this->redirectToRoute('community_show', array('id' => $id));
            }
        }

        $membership = new Membership();
        $membership->setCommunity($community);
        $membership->setStudent($student);
        $membership->setEntryDate();

        $em = $this->getDoctrine()->getManager();
        $em->persist($membership);
        $em->flush();

        $this->addFlash('success', 'Вы успешно вступили в сообщество.');
        return $this->redirectToRoute('community_show', array('id' => $id));
    }

    /**
     * @Route(path="/community/{id}/exit", name="community_exit")
     */
    public function exitAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $student = $this->getUser()->getStudent();

        $community = $this->getDoctrine()->getRepository('AppBundle:Community')->getCommunityWithMembers($id);
        if (!$community)
        {
            throw $this->createNotFoundException('Сообщества с таким id не существует');
        }

        foreach($community->getMemberships() as $membership)
        {
            if ($student === $membership->getStudent())
            {
                $em = $this->getDoctrine()->getManager();
                $em->remove($membership);
                $em->flush();

                $this->addFlash('success', 'Вы успешно вышли из сообщества.');
                return $this->redirectToRoute('student_show', array('id' => $student->getId()));
            }
        }
        $this->addFlash('warning', 'Вы не можете покинуть сообщество, в которое не вступали.');
        return $this->redirectToRoute('student_show', array('id' => $student->getId()));
    }

    /**
     * @Route(path="/community/{id}/members", name="community_members")
     */
    public function listMembersAction($id)
    {
        $community = $this->getDoctrine()->getRepository('AppBundle:Community')->getCommunityWithMembers($id);
        if (!$community)
        {
            throw $this->createNotFoundException('Сообщества с таким id не существует');
        }

        return $this->render('community/members.html.twig', array('community' => $community));
    }

    /**
     * @Route(path="/admin/communities", name="admin_communities_list")
     */
    public function adminListAction()
    {
        $communities = $this->getDoctrine()->getRepository('AppBundle:Community')
            ->getCommunities();

        return $this->render('community/admin_list.html.twig', array('communities' => $communities));
    }
}
