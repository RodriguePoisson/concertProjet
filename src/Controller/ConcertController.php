<?php

namespace App\Controller;



use App\Entity\ConcertConcert;
use App\Entity\ConcertArtist;
use App\Entity\ConcertBand;
use App\Form\AddConcertFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Filesystem\Filesystem;

class ConcertController extends AbstractController
{
    /**
     * @Route("/", name="concert")
     */
    public function indexAction(): Response
    {
        return $this->redirectToRoute('trouver_concert');
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
     * @Route("/concertByYear/{year}/{page}",name="concert_by_year",defaults={"page"=1})
     */
    public function concertByYearAction(String $page,String $year):Response
    { 
        $numberPage = ceil($this->getDoctrine()->getRepository(ConcertConcert::class)->getConcertCountByYear($year)['count(*)']/6);
        
        return $this->render('concert/concertListByYear.html.twig',[
            'concerts'=>$this->getDoctrine()->getRepository(ConcertConcert::class)->getConcertInLimitByYear((6*$page)-6,6*$page,$year),
            'page'=>$page,
            'numberPage'=>$numberPage,
            'year'=>$year
            
        ]);
    }


    /**
     * @Route("/admin/addConcert",name="add_concert")
     * @isGranted("ROLE_ADMIN") 
     */
    public function addConcertAction(Request $request, EntityManagerInterface $entityManager):Response
    {
        $concert = new ConcertConcert();
        $form = $this->createForm(AddConcertFormType::class,$concert);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $pictureFile = $form->get('picture')->getViewData();
            $destination = $this->getParameter('kernel.project_dir').'/public/image/concerts';
            $pictureName = uniqid().'-'.$pictureFile->getClientOriginalName();
            $concert->setPicture($pictureName);
            $pictureFile->move($destination,$pictureName);
            $entityManager->persist($concert);
            $entityManager->flush();
            return $this->redirectToRoute('trouver_concert');
        }

        return $this->render('concert/addConcert.html.twig',[
            'addConcertForm' => $form->createView()]);
    }

    /**
     * @Route("/admin/modifyConcert/{id}",name="modify_concert")
     * @isGranted("ROLE_ADMIN")
     */
    public function modifyConcertAction(String $id, Request $request, EntityManagerInterface $entityManager):Response
    {
        $concert = $this->getDoctrine()->getRepository(ConcertConcert::class)->find($id);
        $form = $this->createForm(AddConcertFormType::class,$concert);
        $form->handleRequest($request);
        $formView = $form->createView();
        $formView->children['picture']->vars["required"] = false;

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $pictureFile = $form->get('picture')->getViewData();
            if(!empty($pictureFile))
            {
                $file = new Filesystem();
                $file->remove($this->getParameter('kernel.project_dir').'/public/image/concerts/'.$concert->getPicture());
                $destination = $this->getParameter('kernel.project_dir').'/public/image/concerts';
                $pictureName = uniqid().'-'.$pictureFile->getClientOriginalName();
                $concert->setPicture($pictureName);
                $pictureFile->move($destination,$pictureName);
            }

            $entityManager->persist($concert);
            $entityManager->flush();
            return $this->redirectToRoute('trouver_concert');
        }

        return $this->render('concert/modifyConcert.html.twig',[
            'concert'=>$concert,
            'concert_form'=>$formView
        ]);
    }

    /**
     * @Route("/admin/deleteConcert/{id}",name="delete_concert")
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteConcertAction(String $id,EntityManagerInterface $entityManager):Response
    {
        $concert = $this->getDoctrine()->getRepository(ConcertConcert::class)->find($id);
        $file = new Filesystem();
        $entityManager->remove($concert);
        $entityManager->flush();
        $file->remove($this->getParameter('kernel.project_dir').'/public/image/concerts/'.$concert->getPicture());
        return $this->redirectToRoute('trouver_concert');
    }

     /**
     * @Route("/user/removeBandInConcert/{idConcert},{idBand}",name="remove_band_concert")
     * @isGranted("ROLE_ADMIN")
     */
    public function removeBandInConcertAction(String $idBand,String $idConcert,EntityManagerInterface $entityManager):Response
    {
        
        $band = $this->getDoctrine()->getRepository(ConcertBand::class)->find($idBand);
        $concert = $this->getDoctrine()->getRepository(ConcertConcert::class)->find($idConcert);

        $concert->removeBandIn($band);

        $entityManager->flush();

        return $this->redirectToRoute('concertOverview',['id'=>$concert->getId()]);
    }
      /**
     * @Route("/user/removeArtistInConcert/{idConcert},{idArtist}",name="remove_artist_concert")
     * @isGranted("ROLE_ADMIN")
     */
    public function removeArtistInConcertAction(String $idArtist,String $idConcert,EntityManagerInterface $entityManager):Response
    {
        $artist = $this->getDoctrine()->getRepository(ConcertArtist::class)->find($idArtist);
        $concert = $this->getDoctrine()->getRepository(ConcertConcert::class)->find($idConcert);

        $concert->removeArtistInvited($artist);

        $entityManager->flush();

        return $this->redirectToRoute('concertOverview',['id'=>$concert->getId()]);
    }

    /**
     * @Route("/concerts/page/{page}",name="trouver_concert",defaults={"page"=1})
     */
    public function concertListActionPaginated(String $page):Response
    {
        
        $concerts = $this->getDoctrine()->getRepository(ConcertConcert::class)->findAll();//getConcertInLimit((6*$page)-6,6*$page);
        $concerts_to_go = [];
        foreach($concerts as $concert)
        {
            if(date_timestamp_get($concert->getDate())>time())
            {
                array_push($concerts_to_go,$concert);
            }
        }
        $numberPage = ceil(count($concerts_to_go)/6);
        return $this->render('concert/concertList.html.twig',[
            'concerts'=>array_slice($concerts_to_go,$page*6-6,6),
            'page'=>$page,
            'numberPage'=>$numberPage,
            
        ]);
    }

    /**
     * @Route("/concerts/{id}",name="concertOverview")
     */
    public function concertOverviewAction(String $id):Response
    {
        return $this->render('/concert/concertOverview.html.twig',[
            'concert'=>$this->getDoctrine()->getRepository(ConcertConcert::class)->find($id)
        ]);
    }
    
}
