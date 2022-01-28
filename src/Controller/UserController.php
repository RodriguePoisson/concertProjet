<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="user_profile")
     * @isGranted("ROLE_USER")
     */
    public function userProfileAction(String $id, Request $request,EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserFormType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $user->setName($request->request->get("user_form")["name"]);
            $user->setLastName($request->request->get("user_form")["last_name"]);
            $entityManager->persist($user);
            $entityManager->flush();
        }
        else if($form->isSubmitted())
        {
            dump($form->getErrors());
            die();
        }

        return $this->render('/user/user_profile.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
