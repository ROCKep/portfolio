<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Job;
use AppBundle\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends Controller
{
    /**
     * @Route(path="/job/new", name="job_new")
     */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $job = new Job();
        $job->setStudent($this->getUser()->getStudent());

        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();
            $this->addFlash('success', 'Место работы добавлено успешно');
            return $this->redirectToRoute('student_show');
        }
        return $this->render('job/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(path="/job/edit/{id}", name="job_edit")
     */
    public function editAction(Request $request, $id)
    {
        if(!$this->isGranted('ROLE_USER') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $job = $this->getDoctrine()->getRepository('AppBundle:Job')->find($id);

        if (!$job) {
            throw $this->createNotFoundException('Места работы с таким id не существует');
        }

        if ($this->isGranted('ROLE_USER') && $this->getUser()->getStudent() !== $job->getStudent()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'Место работы изменено успешно');
            return $this->redirectToRoute('student_show', array('id' => $job->getStudent()->getId()));
        }
        return $this->render('job/edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(path="/job/delete/{id}", name="job_delete")
     */
    public function deleteAction($id)
    {
        if(!$this->isGranted('ROLE_USER') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $job = $this->getDoctrine()->getRepository('AppBundle:Job')->find($id);
        if (!$job) {
            throw $this->createNotFoundException('Места работы с таким id не существует');
        }

        if ($this->isGranted('ROLE_USER') && $this->getUser()->getStudent() !== $job->getStudent()) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($job);
        $em->flush();

        $this->addFlash('success', 'Место работы удалено успешно');
        return $this->redirectToRoute('student_show', array('id' => $job->getStudent()->getId()));
    }
}
