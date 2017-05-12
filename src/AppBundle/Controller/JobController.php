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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $this->denyAccessUnlessGranted('ROLE_USER');
        }
        $job = new Job();
        $job->setUser($this->getUser());
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();
            $this->addFlash('success', 'Место работы добавлено успешно');
            return $this->redirectToRoute('user_show');
        }
        return $this->render('job/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
