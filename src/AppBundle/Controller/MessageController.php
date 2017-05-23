<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends Controller
{
    /**
     * @Route(path="/message/new/{id}", name="message_new")
     */
    public function newAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $sender = $this->getUser()->getStudent();

        $receiver = $this->getDoctrine()->getRepository('AppBundle:Student')->find($id);
        if (!$receiver)
        {
            throw $this->createNotFoundException('Студента с таким id не существует');
        }

        $message = new Message();
        $message->setSender($sender);
        $message->setReceiver($receiver);

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            $this->addFlash('success', 'Сообщение отправлено успешно');
            return $this->redirectToRoute('student_show', array('id' => $receiver->getId()));
        }
        return $this->render('message/new.html.twig', array(
            'form' => $form->createView(),
            'receiver' => $receiver
        ));
    }

    /**
     * @Route(path="/message/chats", name="message_chats")
     */
    public function listChatsAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $student = $this->getUser()->getStudent();

        $chats = $this->getDoctrine()->getRepository('AppBundle:Message')
            ->getChats($student->getId());

        return $this->render('message/chats.html.twig', array('chats' => $chats));
    }

    /**
     * @Route(path="/message/chat/{fellow_id}", name="message_chat")
     */
    public function chatAction(Request $request, $fellow_id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $student = $this->getUser()->getStudent();

        $fellow = $this->getDoctrine()->getRepository('AppBundle:Student')
            ->find($fellow_id);
        if (!$fellow)
        {
            throw $this->createNotFoundException("Пользователя с таким id не существует");
        }

        $messages = $this->getDoctrine()->getRepository('AppBundle:Message')
            ->getAllMessagesWithFellow($student->getId(), $fellow_id);

        if (!$messages)
        {
            throw $this->createNotFoundException("Беседы с пользователем с таким id не существует");
        }

        $message = new Message();
        $message->setSender($student);
        $message->setReceiver($fellow);

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('message_chat', array('fellow_id' => $fellow_id));
        }

        return $this->render('message/chat.html.twig', array(
            'student' => $student,
            'fellow' => $fellow,
            'messages' => $messages,
            'form' => $form->createView()
        ));
    }
}
