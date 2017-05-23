<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Material;
use AppBundle\Entity\Photo;
use AppBundle\Form\AddMaterialType;
use AppBundle\Form\CommentType;
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
        $this->denyAccessUnlessGranted('ROLE_USER');
        $student = $this->getUser()->getStudent();

        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($cat_id);
        if (!$category) {
            throw $this->createNotFoundException('Категории с таким id не существует');
        }

        if ($community = $category->getCommunity()) {
            $members = $this->getDoctrine()->getRepository('AppBundle:Student')
                ->getMembersOfCommunity($community->getId());
            if (!in_array($student, $members)) {
                throw $this->createAccessDeniedException();
            }
        }

        $material = new Material();
        $material->setAuthor($student);
        $material->setCategory($category);

        $form = $this->createForm(AddMaterialType::class, $material);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $photoFiles = $form->get('photoFiles')->getData();
            foreach ($photoFiles as $photoFile)
            {
                $photo = new Photo();
                $photo->setOriginal($photoFile);
                $material->addPhoto($photo);
            }

            $material->setDate();

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

    /**
     * @Route(path="/material/{id}/delete", name="material_delete")
     */
    public function deleteAction($id)
    {
        if(!$this->isGranted('ROLE_USER') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $material = $this->getDoctrine()->getRepository('AppBundle:Material')
            ->getMaterialWithAuthor($id);
        if (!$material) {
            throw $this->createNotFoundException('Материала с таким id не существует');
        }

        if ($this->isGranted('ROLE_USER')) {
            $student = $this->getUser()->getStudent();
            if ($material->getAuthor() !== $student && $student !== $material->getCategory()->getCommunity()->getCreator()) {
                throw $this->createAccessDeniedException();
            }
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($material);
        $em->flush();

        $this->addFlash('success', 'Материал удален успешно');
        return $this->redirectToRoute('cat_show', array('id' => $material->getCategory()->getId()));
    }

    /**
     * @Route(path="/material/{id}", name="material_show")
     */
    public function showAction(Request $request, $id)
    {
        $material = $this->getDoctrine()->getRepository('AppBundle:Material')->find($id);
        if (!$material) {
            throw $this->createNotFoundException('Материала с таким id не существует');
        }

        $parameters = array('material' => $material);

        if ($this->isGranted('ROLE_USER')) {
            $comment = new Comment();
            $comment->setStudent($this->getUser()->getStudent());

            $form = $this->createForm(CommentType::class, $comment);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())
            {
                $comment->setTime();
                $comment->setMaterial($material);
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                $this->addFlash('success', 'Комментарий сохранен успешно');
                return $this->redirectToRoute('material_show', array('id' => $id));
            }
            $parameters['form'] = $form->createView();
        }

        return $this->render('material/show.html.twig', $parameters);
    }
}
