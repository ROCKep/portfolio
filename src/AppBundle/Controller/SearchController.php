<?php

namespace AppBundle\Controller;

use AppBundle\Form\DoSearchType;
use AppBundle\Form\Model\Search;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends Controller
{
    /**
     * @Route(path="/search", name="search")
     */
    public function indexAction(Request $request)
    {
        $search = new Search();
        $form = $this->createForm(DoSearchType::class, $search, array(
            'method' => 'GET'
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            switch ($search->getCriteria())
            {
                case 'student':
                    $students = $this->getDoctrine()->getRepository('AppBundle:Student')
                        ->getStudentsLike($search->getSearch());
                    return $this->render('search/student.html.twig', array('students' => $students));
                case 'community':
                    $communities = $this->getDoctrine()->getRepository('AppBundle:Community')
                        ->getCommunitiesLike($search->getSearch());
                    return $this->render('search/community.html.twig', array('communities' => $communities));
            }
        }

        return $this->render('search/index.html.twig', array('form' => $form->createView()));
    }
}
