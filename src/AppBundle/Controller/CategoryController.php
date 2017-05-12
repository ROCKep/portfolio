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
    public function showAction($id = null)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');
        if ($id === null)
        {
            if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
            {
                $this->denyAccessUnlessGranted('ROLE_USER');
            }
            $user = $this->getUser();
            $root = $repository->findRootByUserId($user->getId());
            return $this->redirectToRoute('cat_show', array('id' => $root->getId()));
        }
        $category = $repository->find($id);
        if (!$category)
        {
            return $this->createNotFoundException('Категории с таким id не существует');
        }

        $breadcrumbs = $repository->getBreadcrumbs($id);
        return $this->render('category/show.html.twig', array('category' => $category, 'breadcrumbs' => $breadcrumbs));
    }

    /**
     * @Route(path="/cat/new/{id}", name="cat_new")
     */
    public function newAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $this->denyAccessUnlessGranted('ROLE_USER');
        }

        $parent = $this->getDoctrine()->getRepository('AppBundle:Category')->find($id);
        if(!$parent)
        {
            return $this->createNotFoundException('Категории с таким id не существует');
        }
        $category = new Category();
        //$category->setUser($this->getUser());
        $category->setParent($parent);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Категория добавлена успешно');
            return $this->redirectToRoute('cat_show', array('id' => $parent->getId()));
        }

        return $this->render('category/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route(path="/cat/edit/{id}", name="cat_edit")
     */
    public function editAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $this->denyAccessUnlessGranted('ROLE_USER');
        }

        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($id);
        if(!$category)
        {
            return $this->createNotFoundException('Категории с таким id не существует');
        }
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Категория отредактирована успешно');
            return $this->redirectToRoute('cat_show', array('id' => $category->getParent()->getId()));
        }
        return $this->render('category/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route(path="/cat/delete/{id}", name="cat_delete")
     */
    public function deleteAction($id)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($id);
        if(!$category)
        {
            return $this->createNotFoundException('Категории с таким id не существует');
        }
        if($category->getParent() == null)
        {
            $this->addFlash('error', 'Невозможно удалить корень');
            return $this->redirectToRoute('cat_show', array('id' => $category->getId()));
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        $this->addFlash('success', 'Категория удалена успешно');
        return $this->redirectToRoute('cat_show', array('id' => $category->getParent()->getId()));
    }
}