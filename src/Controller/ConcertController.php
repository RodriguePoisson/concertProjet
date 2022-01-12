<?php

namespace App\Controller;


use App\Entity\ConcertArtist;
use App\Entity\ConcertBand;


use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcertController extends AbstractController
{
    /**
     * @Route("/concert", name="concert")
     */
    public function indexAction(): Response
    {
        return $this->render('concert/index.html.twig', [
            'controller_name' => 'ConcertController',
        ]);
    }

    /**
     * @Route("/concert/{name}", name = "list")
     */
    public function listConcertAction(String $name): Response
    {
        return $this->render('concert/index.html.twig',[
            'name' => $name
        ]);
    }

    /**
     * @Route("/bands", name= "bandLists")
     */
    public function listBandsAction(): Response
    {
        return $this->render('bands/index.html.twig',[
            'bands'=>$this->getDoctrine()->getRepository(ConcertBand::class)->findAll()
        ]);
    }

    /**
     * @Route("/band/{id}",name="bandOverview")
     */
    public function bandOverviewAction(String $id):Response
    {
        return $this->render('bands/bandOverview.html.twig',[
            'band'=>$this->getDoctrine()->getRepository(ConcertBand::class)->find($id)
        ]);
    }
    /**
     * @Route("/artist/{id}",name="artistOverview")
     */
    public function artistOverviewAction(String $id):Response
    {
        return $this->render('artists/artistOverview.html.twig',[
            'artist'=>$this->getDoctrine()->getRepository(ConcertArtist::class)->find($id)
        ]);
    }
}
