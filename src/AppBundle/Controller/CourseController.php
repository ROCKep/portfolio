<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use AppBundle\Form\CourseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends Controller
{
    /**
     * @Route(path="/admin/courses", name="courses_list")
     */
    public function listAction()
    {
        $courses = $this->getDoctrine()->getRepository('AppBundle:Course')->getCourses();
        return $this->render('course/list.html.twig', array('courses' => $courses));
    }

    /**
     * @Route(path="/admin/course/new", name="course_new")
     */
    public function newAction(Request $request)
    {
        $course = new Course();

        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($course);
            $em->flush();

            $this->addFlash('success', 'Направление добавлено успешно.');
            return $this->redirectToRoute('courses_list');
        }

        return $this->render('/course/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(path="/admin/course/{id}/edit", name="course_edit")
     */
    public function editAction(Request $request, $id)
    {
        $course = $this->getDoctrine()->getRepository('AppBundle:Course')->find($id);
        if (!$course) {
            throw $this->createNotFoundException('Направления с таким id не существует.');
        }

        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Направление изменено успешно.');
            return $this->redirectToRoute('courses_list');
        }

        return $this->render('course/edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(path="/admin/course/{id}/delete", name="course_delete")
     */
    public function deleteAction($id)
    {
        $course = $this->getDoctrine()->getRepository('AppBundle:Course')->find($id);
        if (!$course) {
            throw $this->createNotFoundException('Направления с таким id не существует.');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($course);
        $em->flush();

        $this->addFlash('success', 'Направление удалено успешно');
        return $this->redirectToRoute('courses_list');
    }
}