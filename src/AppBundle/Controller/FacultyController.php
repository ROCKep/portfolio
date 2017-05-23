<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Faculty;
use AppBundle\Form\FacultyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FacultyController extends Controller
{
    /**
     * @Route(path="/admin/faculties", name="faculties_list")
     */
    public function listAction()
    {
        $faculties = $this->getDoctrine()->getRepository('AppBundle:Faculty')->getFaculties();
        return $this->render('faculty/list.html.twig', array('faculties' => $faculties));
    }

    /**
     * @Route(path="/admin/faculty/new", name="faculty_new")
     */
    public function newAction(Request $request)
    {
        $faculty = new Faculty();
        $form = $this->createForm(FacultyType::class, $faculty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($faculty);
            $em->flush();

            $this->addFlash('success', 'Факультет добавлен успешно');
            return $this->redirectToRoute('faculties_list');
        }

        return $this->render('faculty/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(path="/admin/faculty/{id}/edit", name="faculty_edit")
     */
    public function editAction(Request $request, $id)
    {
        $faculty = $this->getDoctrine()->getRepository('AppBundle:Faculty')->find($id);
        if (!$faculty) {
            throw $this->createNotFoundException('Факультета с таким id не существует.');
        }

        $form = $this->createForm(FacultyType::class, $faculty);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Факультет изменен успешно.');
            return $this->redirectToRoute('faculties_list');
        }

        return $this->render('faculty/edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(path="/admin/faculty/{id}/delete", name="faculty_delete")
     */
    public function deleteAction($id)
    {
        $faculty = $this->getDoctrine()->getRepository('AppBundle:Faculty')->find($id);
        if (!$faculty) {
            throw $this->createNotFoundException('Факультета с таким id не существует.');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($faculty);
        $em->flush();

        $this->addFlash('success', 'Факультет удален успешно');
        return $this->redirectToRoute('faculties_list');
    }
}
