<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Photo;
use AppBundle\Form\AccountType;
use AppBundle\Form\ChangeAvatarType;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Form\EditInfoType;
use AppBundle\Form\Model\ChangePassword;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends Controller
{
    /**
     * @Route(path="/student/{id}", name="student_show")
     */
    public function showAction($id = null)
    {
        if ($id === null)
        {
            $this->denyAccessUnlessGranted('ROLE_USER');

            $student= $this->getUser()->getStudent();
            return $this->redirectToRoute('student_show', array('id' => $student->getId()));
        }

        $student = $this->getDoctrine()
            ->getRepository('AppBundle:Student')
            ->getAllInfoAboutStudent($id);
        if (!$student) {
            throw $this->createNotFoundException("Пользователя с таким id не существует");
        }

        $root_category = $this->getDoctrine()->getRepository('AppBundle:Category')
            ->getRootByStudentId($id);

        return $this->render('student/show.html.twig', array(
            'student' => $student,
            'root_category' => $root_category
        ));
    }

    /**
     * @Route(path="/student/{id}/edit", name="student_edit")
     */
    public function editMainAction(Request $request, $id)
    {
        $student = $this->getDoctrine()->getRepository('AppBundle:Student')->find($id);
        if (!$student) {
            throw $this->createNotFoundException('Студента с таким id не существует');
        }

        if($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_USER') && $this->getUser()->getStudent() === $student) {
            $form = $this->createForm(EditInfoType::class, $student);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Изменения сохранены');
                return $this->redirectToRoute('student_show', array('id' => $id));
            }

            return $this->render('student/edit/main.html.twig', array('student' => $student, 'form' => $form->createView()));
        }
        else {
            throw $this->createAccessDeniedException();
        }
    }

    /**
     * @Route(path="/student/{id}/edit/security", name="student_edit_security")
     */
    public function editSecurityAction(Request $request, $id)
    {
        $student = $this->getDoctrine()->getRepository('AppBundle:Student')->find($id);
        if (!$student) {
            throw $this->createNotFoundException('Студента с таким id не существует');
        }

        if ($this->isGranted('ROLE_USER') && $this->getUser()->getStudent() === $student) {

            $account = $student->getAccount();
            $changePasswordModel = new ChangePassword();
            $form = $this->createForm(ChangePasswordType::class, $changePasswordModel);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $password = $this->get('security.password_encoder')
                    ->encodePassword($account, $changePasswordModel->getNewPassword());
                $account->setPassword($password);

                $em = $this->getDoctrine()->getManager();
                $em->persist($account);
                $em->flush();

                $this->addFlash('success', 'Изменения сохранены');
                return $this->redirectToRoute('student_edit', array('id' => $id));
            }

            return $this->render('student/edit/security.html.twig', array('student' => $student, 'form' => $form->createView()));
        }
        elseif ($this->isGranted('ROLE_ADMIN')) {

            $account = $student->getAccount();

            $form = $this->createForm(AccountType::class, $account);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $password = $this->get('security.password_encoder')
                    ->encodePassword($account, $account->getPlainPassword());
                $account->setPassword($password);

                $em = $this->getDoctrine()->getManager();
                $em->persist($account);
                $em->flush();

                $this->addFlash('success', 'Изменения сохранены');
                return $this->redirectToRoute('student_edit', array('id' => $id));
            }

            return $this->render('student/edit/admin_security.html.twig', array('student' => $student, 'form' => $form->createView()));
        }
        else {
            throw $this->createAccessDeniedException();
        }
    }

    /**
     * @Route(path="/student/{id}/edit/avatar", name="student_edit_avatar")
     */
    public function editAvatarAction(Request $request, $id)
    {
        $student = $this->getDoctrine()->getRepository('AppBundle:Student')->find($id);
        if (!$student) {
            throw $this->createNotFoundException('Студента с таким id не существует');
        }

        if($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_USER') && $this->getUser()->getStudent() === $student) {

            $form = $this->createForm(ChangeAvatarType::class, $student);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $avatar = new Photo();
                $avatar->setOriginal($form->get('avatarFile')->getData());
                $student->setAvatar($avatar);
                $em = $this->getDoctrine()->getManager();
                $em->persist($student);
                $em->flush();
                $this->addFlash('success', 'Изменения сохранены');
                return $this->redirectToRoute('student_edit', array('id' => $id));
            }

            return $this->render('student/edit/avatar.html.twig', array('student' => $student, 'form' => $form->createView()));
        }
        else {
            throw $this->createAccessDeniedException();
        }
    }

    /**
     * @Route(path="/student/{id}/memberships", name="memberships_list")
     */
    public function listMembershipsAction($id)
    {
        $student = $this->getDoctrine()->getRepository('AppBundle:Student')->getStudentWithMemberships($id);
        if (!$student)
        {
            throw $this->createNotFoundException('Пользователя с таким id не существует');
        }

        return $this->render('student/memberships.html.twig', array(
            'student' => $student
        ));
    }


    /**
     * @Route(path="/admin/students/{id}", name="admin_students_list")
     */
    public function adminListAction($id)
    {
        $group = $this->getDoctrine()->getRepository('AppBundle:Group')
            ->getGroupWithStudents($id);
        if (!$group) {
            throw $this->createNotFoundException('Группы с таким id не существует.');
        }

        return $this->render('student/admin_list.html.twig', array('group' => $group));
    }

    /**
     * @Route(path="/admin/student/{id}/delete", name="admin_student_delete")
     */
    public function adminDeleteAction($id)
    {
        $student = $this->getDoctrine()->getRepository('AppBundle:Student')
            ->getStudentWithGroup($id);
        if (!$student) {
            throw $this->createNotFoundException('Пользователя с таким id не существует.');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();

        $this->addFlash('success', 'Пользователь удален успешно.');
        return $this->redirectToRoute('admin_students_list', array('id' => $student->getGroup()->getId()));
    }
}