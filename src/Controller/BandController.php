<?php
namespace App\Controller;

use App\Entity\ConcertArtist;
use App\Entity\ConcertBand;
use App\Entity\User;

use App\Form\BandFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Filesystem\Filesystem;


class BandController extends AbstractController
{
    /**
     * @Route("/bands/page/{page}", name= "bandLists",defaults={"page"=1})
     */
    public function listBandsAction(String $page): Response
    {
        $numberPage = ceil($this->getDoctrine()->getRepository(ConcertBand::class)->getBandCount()/6);
        if($numberPage=='0')
        {
            $numberPage = 1;
        }
        return $this->render('bands/index.html.twig',[
            'bands'=>$this->getDoctrine()->getRepository(ConcertBand::class)->getBandInLimit(6*$page-6,6*$page),
            'page'=>$page,
            'numberPage'=>$numberPage,
            
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
     * @Route("/admin/addBand",name="add_band")
     * @isGranted("ROLE_ADMIN")
     */
    public function addBandAction(Request $request, EntityManagerInterface $entityManager):Response
    {
        $band = new ConcertBand();
        $form = $this->createForm(BandFormType::class,$band);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $pictureFile = $form->get('picture')->getViewData();
            $destination = $this->getParameter('kernel.project_dir').'/public/image/bands';
            $pictureName = uniqid().'-'.$pictureFile->getClientOriginalName();
            $band->setPicture($pictureName);
            $pictureFile->move($destination,$pictureName);
            $entityManager->persist($band);
            $entityManager->flush();
            return $this->redirectToRoute('bandLists');
        }

        return $this->render('bands/addBand.html.twig',[
            'band_form' => $form->createView()]);
    }

    /**
     * @Route("/admin/modifyBand/{id}",name="modify_band")
     * @isGranted("ROLE_ADMIN")
     */
    public function modifyBandAction(String $id,EntityManagerInterface $entityManager,Request $request):Response
    {
        $band = $this->getDoctrine()->getRepository(ConcertBand::class)->find($id);
        $form = $this->createForm(BandFormType::class,$band);
        $form->handleRequest($request);
        $formView = $form->createView();
        $formView->children['picture']->vars["required"] = false;

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $pictureFile = $form->get('picture')->getViewData();
            if(!empty($pictureFile))
            {
                $file = new Filesystem();
                $file->remove($this->getParameter('kernel.project_dir').'/public/image/bands/'.$band->getPicture());
                $destination = $this->getParameter('kernel.project_dir').'/public/image/bands';
                $pictureName = uniqid().'-'.$pictureFile->getClientOriginalName();
                $band->setPicture($pictureName);
                $pictureFile->move($destination,$pictureName);
            }

            $entityManager->persist($band);
            $entityManager->flush();
            return $this->redirectToRoute('bandLists');
        }

        return $this->render('bands/modifyBand.html.twig',[
            'band'=>$band,
            'band_form'=>$formView
        ]);
    }

    /**
     * @Route("/admin/deleteBand/{id}",name="delete_band")
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteBandAction(String $id,EntityManagerInterface $entityManager):Response
    {
        $band = $this->getDoctrine()->getRepository(ConcertBand::class)->find($id);
        $file = new Filesystem();
        $entityManager->remove($band);
        $entityManager->flush();
        $file->remove($this->getParameter('kernel.project_dir').'/public/image/bands/'.$band->getPicture());
        return $this->redirectToRoute('bandLists');
    }

    /**
     * @Route("/user/addFavoriteBand/{id}",name="add_favorite_band")
     * @isGranted("ROLE_USER")
     */
    public function addFavoriteBandAction(String $id,EntityManagerInterface $entityManager):Response
    {
        if($this->getUser())
        {
           
           // $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser()->getId());
            
            $band = $this->getDoctrine()->getRepository(ConcertBand::class)->find($id);
            
            
            $this->getUser()->addFavoriteBand($band);

            $entityManager->flush();
        }
     
        return $this->redirectToRoute('bandLists');
    }

    /**
     * @Route("/user/removeFavoriteBand/{id}",name="remove_favorite_band")
     * @isGranted("ROLE_USER")
     */
    public function deleteFavoriteAction(String $id,EntityManagerInterface $entityManager):Response
    {
        $band = $this->getDoctrine()->getRepository(ConcertBand::class)->find($id);
            
            
        $this->getUser()->removeFavoriteBand($band);

        $entityManager->flush();

        return $this->redirectToRoute('bandLists');
        
    }

    /**
     * @Route("/user/removeArtistInGroup/{idBand}/{idArtist}",name="remove_artist_band")
     * @isGranted("ROLE_ADMIN")
     */
    public function removeArtistInBandAction(String $idBand,String $idArtist,EntityManagerInterface $entityManager):Response
    {
        $band = $this->getDoctrine()->getRepository(ConcertBand::class)->find($idBand);
        $artist = $this->getDoctrine()->getRepository(ConcertArtist::class)->find($idArtist);

        $band->removeArtist($artist);

        $entityManager->flush();

        return $this->redirectToRoute('bandOverview',['id'=>$band->getId()]);
    }

    /**
     * @Route("/band/concert/{id}",name="get_concert_band")
     */
    public function getConcertBand(String $id):Response
    {
        $band = $this->getDoctrine()->getRepository(ConcertBand::class)->find($id);
        
        
        $concerts = $band->getConcerts();
        $concerts_to_go = [];

        foreach($concerts as $concert)
        {
            if(date_timestamp_get($concert->getDate())>time())
            {
                array_push($concerts_to_go,$concert);
            }
        }
        
     
        return $this->render('/bands/listConcertForBand.html.twig',[
            'concerts'=>$concerts_to_go,
            'band'=>$band
        ]);
    }
}

?>