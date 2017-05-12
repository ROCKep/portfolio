<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Material;
use AppBundle\Form\MaterialType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MaterialController extends Controller
{
    /**
     * @Route(path="/material/new/{cat_id}", name="material_new")
     */
    public function newAction(Request $request, $cat_id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $this->denyAccessUnlessGranted('ROLE_USER');
        }

        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($cat_id);
        if (!$category)
        {
            return $this->createNotFoundException('Категории с таким id не существует');
        }

        $material = new Material();
        $material->setCategory($category);
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($material);
            $em->flush();
            $this->addFlash('success', 'Материал создан успешно');
            return $this->redirectToRoute('cat_show', array('id' => $category->getId()));
        }

        return $this->render('material/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
