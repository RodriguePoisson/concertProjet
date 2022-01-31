<?php

namespace App\Controller;

use App\Entity\ConcertArtist;
use App\Entity\ConcertBand;
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
     * @Route("/user/favoriteBand/{page}",name="user_favorite_band",defaults={"page"=1})
     * @isGranted("ROLE_USER")
     */
    public function userFavoriteBandAction(String $page): Response
    {
        $numberPage = ceil($this->getDoctrine()->getRepository(ConcertBand::class)->getBandCountByUser($this->getUser()->getId())['COUNT(*)']/6);

        if($numberPage=='0')
        {
            $numberPage = '1';
        }
        $favoriteBands = $this->getDoctrine()->getRepository(ConcertBand::class)->getFavoriteBand($this->getUser()->getId(),6*$page-6,6*$page);

        return $this->render("user/user_favorite_band.html.twig",[
            'numberPage'=>$numberPage,
            'page'=>$page,
            'bands'=>$favoriteBands
        ]);
    }
    /**
     * @Route("/user/favoriteArtist/{page}",name="user_favorite_artist",defaults={"page"=1})
     * @isGranted("ROLE_USER")
     */
    public function userFavoriteArtistAction(String $page): Response
    {
        $numberPage = ceil($this->getDoctrine()->getRepository(ConcertArtist::class)->getArtistCountByUser($this->getUser()->getId())['COUNT(*)']/6);

        if($numberPage=='0')
        {
            $numberPage = '1';
        }
        $favoriteArtists = $this->getDoctrine()->getRepository(ConcertArtist::class)->getFavoriteArtist($this->getUser()->getId(),6*$page-6,6*$page);

        return $this->render("user/user_favorite_artist.html.twig",[
            'numberPage'=>$numberPage,
            'page'=>$page,
            'artists'=>$favoriteArtists
        ]);
    }
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

