<?php

namespace App\Controller;
use App\Entity\ConcertArtist;
use App\Entity\ConcertBand;
use App\Entity\ConcertConcert;
use App\Form\AddConcertFormType;
use App\Form\ArtistFormType;
use App\Repository\ConcertArtistRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Filesystem\Filesystem;

class ArtistController extends AbstractController
{
    /**
     * @Route("/artist/{id}",name="artistOverview")
     */
    public function artistOverviewAction(String $id):Response
    {
        return $this->render('artists/artistOverview.html.twig',[
            'artist'=>$this->getDoctrine()->getRepository(ConcertArtist::class)->find($id)
        ]);
    }

    /**
     * @Route("/artist",name="artistsList")
     */
    public function artistsListAction()
    {
        $artists_list = $this->getDoctrine()->getRepository(ConcertArtist::class)->findAll();
        return $this->render('artists/artistList.html.twig',[
            'artists'=>$artists_list
        ]);
    }
    
    /**
     * @Route("/admin/addArtist",name="add_artist")
     * @isGranted("ROLE_ADMIN")
     */
    public function addArtistAction(Request $request, EntityManagerInterface $entityManager):Response
    {
        $artist = new ConcertArtist();
        $form = $this->createForm(ArtistFormType::class,$artist);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $pictureFile = $form->get('picture')->getViewData();
            $destination = $this->getParameter('kernel.project_dir').'/public/image/artists';
            $pictureName = uniqid().'-'.$pictureFile->getClientOriginalName();
            $artist->setPicture($pictureName);
            $pictureFile->move($destination,$pictureName);
            $entityManager->persist($artist);
            $entityManager->flush();
            return $this->redirectToRoute('artistsList');
        }

        return $this->render('artists/addArtist.html.twig',[
            'artist_form' => $form->createView()]);
    }

    /**
     * @Route("/admin/modifyArtist/{id}",name="modify_artist")
     * @isGranted("ROLE_ADMIN")
     */
    public function modifyArtistAction(Request $request, EntityManagerInterface $entityManager,String $id):Response
    {
        $artist = $this->getDoctrine()->getRepository(ConcertArtist::class)->find($id);
        $form = $this->createForm(ArtistFormType::class,$artist);
        $form->handleRequest($request);
        $formView = $form->createView();
        $formView->children['picture']->vars["required"] = false;

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $pictureFile = $form->get('picture')->getViewData();
            if(!empty($pictureFile))
            {
                $file = new Filesystem();
                $file->remove($this->getParameter('kernel.project_dir').'/public/image/artists/'.$artist->getPicture());
                $destination = $this->getParameter('kernel.project_dir').'/public/image/artists';
                $pictureName = uniqid().'-'.$pictureFile->getClientOriginalName();
                $artist->setPicture($pictureName);
                $pictureFile->move($destination,$pictureName);
            }
            $entityManager->persist($artist);
            $entityManager->flush();
            return $this->redirectToRoute('artistsList');
        }

        return $this->render('artists/modifyArtist.html.twig',[
            'artist_form'=>$formView
        ]);
    }

    /**
     * @Route("admin/deleteArtist/{id}",name="delete_artist")
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteArtistAction(EntityManagerInterface $entityManager,String $id):Response
    {
        $artist = $this->getDoctrine()->getRepository(ConcertArtist::class)->find($id);

        $entityManager->remove($artist);
        $entityManager->flush();

        $file = new Filesystem();
        $file->remove($this->getParameter('kernel.project_dir').'/public/image/artists/'.$artist->getPicture());
        return $this->redirectToRoute('artistsList');
    }

    /**
     * @Route("/user/addFavoriteArtist/{id}",name="add_favorite_artist")
     * @isGranted("ROLE_USER")
     */
    public function addFavoriteArtistAction(String $id,EntityManagerInterface $entityManager):Response
    {
        if($this->getUser())
        {       
            $artist = $this->getDoctrine()->getRepository(ConcertArtist::class)->find($id);
            
            
            $this->getUser()->addFavoriteArtists($artist);

            $entityManager->flush();
        }
     
        return $this->redirectToRoute('artistsList');
    }

    /**
     * @Route("/user/removeFavoriteArtist/{id}",name="remove_favorite_artist")
     * @isGranted("ROLE_USER")
     */
    public function deleteFavoriteAction(String $id,EntityManagerInterface $entityManager):Response
    {
        $artist = $this->getDoctrine()->getRepository(ConcertArtist::class)->find($id);
            
            
        $this->getUser()->removeFavoriteArtist($artist);

        $entityManager->flush();

        return $this->redirectToRoute('artistsList');
        
    }
}


?>