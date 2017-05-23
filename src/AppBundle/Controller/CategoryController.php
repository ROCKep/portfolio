<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route(path="/cat/{id}", name="cat_show")
     */
    public function showAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $category = $repository->find($id);
        if (!$category) {
            throw $this->createNotFoundException('Категории с таким id не существует');
        }

        $breadcrumbs = $repository->getBreadcrumbs($id);

        $members = array();
        if ($community = $category->getCommunity()) {
            $members = $this->getDoctrine()->getRepository('AppBundle:Student')
                ->getMembersOfCommunity($community->getId());
        }

        return $this->render('category/show.html.twig', array('category' => $category,
            'breadcrumbs' => $breadcrumbs, 'members' => $members));
    }


    /**
     * @Route(path="/cat/{id}/new", name="cat_new")
     */
    public function newAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $student = $this->getUser()->getStudent();

        $parent = $this->getDoctrine()->getRepository('AppBundle:Category')->find($id);
        if(!$parent) {
            throw $this->createNotFoundException('Категории с таким id не существует');
        }

        if ($student === $parent->getStudent() || $student === $parent->getCommunity()->getCreator()) {

            $category = new Category();
            $category->setParent($parent);
            if ($student = $parent->getStudent()) {
                $category->setStudent($student);
            }
            elseif ($community = $parent->getCommunity()) {
                $category->setCommunity($community);
            }

            $form = $this->createForm(CategoryType::class, $category);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $category->setCreatedDate();
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
                $this->addFlash('success', 'Категория добавлена успешно');
                return $this->redirectToRoute('cat_show', array('id' => $parent->getId()));
            }

            return $this->render('category/new.html.twig', array('form' => $form->createView()));
        }
        else {
            throw $this->createAccessDeniedException();
        }
    }

    /**
     * @Route(path="/cat/{id}/edit", name="cat_edit")
     */
    public function editAction(Request $request, $id)
    {
        if(!$this->isGranted('ROLE_USER') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $category = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->getCategoryWithParent($id);
        if(!$category) {
            throw $this->createNotFoundException('Категории с таким id не существует');
        }

        if ($this->isGranted('ROLE_USER') && $this->getUser()->getStudent() !== $category->getStudent() &&
            $this->getUser()->getStudent() !== $category->getCommunity()->getCreator()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'Категория отредактирована успешно');
            return $this->redirectToRoute('cat_show', array('id' => $category->getParent()->getId()));
        }
        return $this->render('category/edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route(path="/cat/{id}/delete", name="cat_delete")
     */
    public function deleteAction($id)
    {
        if(!$this->isGranted('ROLE_USER') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $category = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->getCategoryWithParent($id);
        if(!$category) {
            throw $this->createNotFoundException('Категории с таким id не существует');
        }

        if ($this->isGranted('ROLE_USER') && $this->getUser()->getStudent() !== $category->getStudent() &&
            $this->getUser()->getStudent() !== $category->getCommunity()->getCreator()) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        $this->addFlash('success', 'Категория удалена успешно');
        return $this->redirectToRoute('cat_show', array('id' => $category->getParent()->getId()));
    }
}