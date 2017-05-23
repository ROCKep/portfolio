<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use AppBundle\Form\GroupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends Controller
{
    /**
     * @Route(path="/admin/groups/{id}", name="groups_list")
     */
    public function listAction($id)
    {
        $department = $this->getDoctrine()->getRepository('AppBundle:Department')
            ->getDepartmentWithGroupsAndFaculty($id);
        if (!$department) {
            throw $this->createNotFoundException('Кафедры с таким id не существует.');
        }

        return $this->render('group/list.html.twig', array('department' => $department));
    }

    /**
     * @Route(path="/admin/group/new/{id}", name="group_new")
     */
    public function newAction(Request $request, $id)
    {
        $department = $this->getDoctrine()->getRepository('AppBundle:Department')
            ->find($id);
        if (!$department) {
            throw $this->createNotFoundException('Кафедры с таким id не существует.');
        }

        $group = new Group();
        $group->setDepartment($department);

        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            $this->addFlash('success', 'Группа добавлена успешно.');
            return $this->redirectToRoute('groups_list', array('id' => $id));
        }

        return $this->render('group/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(path="/admin/group/{id}/edit", name="group_edit")
     */
    public function editAction(Request $request, $id)
    {
        $group = $this->getDoctrine()->getRepository('AppBundle:Group')
            ->getGroupWithDepartment($id);
        if (!$group) {
            throw $this->createNotFoundException('Группы с таким id не существует.');
        }

        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Группа изменена успешно.');
            return $this->redirectToRoute('groups_list',
                array('id' => $group->getDepartment()->getId()));
        }

        return $this->render('group/edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(path="/admin/group/{id}/delete", name="group_delete")
     */
    public function deleteAction($id)
    {
        $group = $this->getDoctrine()->getRepository('AppBundle:Group')
            ->getGroupWithDepartment($id);
        if (!$group) {
            throw $this->createNotFoundException('Группы с таким id не существует.');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($group);
        $em->flush();

        $this->addFlash('success', 'Группа удалена успешно.');
        return $this->redirectToRoute('groups_list', array('id' => $group->getDepartment()->getId()));
    }
}
