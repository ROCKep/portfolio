<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Department;
use AppBundle\Form\DepartmentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends Controller
{
    /**
     * @Route(path="/admin/departments/{id}", name="departments_list")
     */
    public function listAction($id)
    {
        $faculty = $this->getDoctrine()->getRepository('AppBundle:Faculty')
            ->getFacultyWithDepartments($id);
        if (!$faculty) {
            throw $this->createNotFoundException('Факультета с таким id не существует');
        }

        return $this->render('department/list.html.twig', array('faculty' => $faculty));
    }

    /**
     * @Route(path="/admin/department/new/{id}", name="department_new")
     */
    public function newAction(Request $request, $id)
    {
        $faculty = $this->getDoctrine()->getRepository('AppBundle:Faculty')
            ->find($id);
        if (!$faculty) {
            throw $this->createNotFoundException('Факультета с таким id не существует');
        }

        $department = new Department();
        $department->setFaculty($faculty);

        $form = $this->createForm(DepartmentType::class, $department);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($department);
            $em->flush();

            $this->addFlash('success', 'Кафедра добавлена успешно');
            return $this->redirectToRoute('departments_list', array('id' => $id));
        }

        return $this->render('department/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(path="/admin/department/{id}/edit", name="department_edit")
     */
    public function editAction(Request $request, $id)
    {
        $department = $this->getDoctrine()->getRepository('AppBundle:Department')
            ->getDepartmentWithFaculty($id);
        if (!$department) {
            throw $this->createNotFoundException('Кафедры с таким id не существует.');
        }

        $form = $this->createForm(DepartmentType::class, $department);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Кафедра изменена успешно.');
            return $this->redirectToRoute('departments_list',
                array('id' => $department->getFaculty()->getId()));
        }

        return $this->render('department/edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(path="/admin/department/{id}/delete", name="department_delete")
     */
    public function deleteAction($id)
    {
        $department = $this->getDoctrine()->getRepository('AppBundle:Department')
            ->getDepartmentWithFaculty($id);
        if (!$department) {
            throw $this->createNotFoundException('Кафедры с таким id не существует.');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($department);
        $em->flush();

        $this->addFlash('success', 'Кафедра удалена успешно.');
        return $this->redirectToRoute('departments_list', array('id' => $department->getFaculty()->getId()));
    }
}
