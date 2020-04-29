<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Evenement;
use App\Form\Photo_profil;
use App\Form\Evenement1Type;
use App\Repository\EvenementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/evenement")
 */
class EvenementController extends AbstractController
{


    /**  
     *
     * @Route("/{id}/image", name="image", methods={"POST"})
     */
    public function editAction(Request $request,$id)
    {
        $profil = $this->getDoctrine()->getRepository(User::class)->find($request->get('id')); 
        $form = $this->createForm(Photo_profil::class, $profil,array(
            'action'=>$this->generateUrl('photo_show', array('id'=>$profil->getId())),
        ));           
            $file=$request->files->all()['imageFile'];
            $profil->setImageFile($file );

            $form->handleRequest($request);
            if($profil->getImageFile()!=null){
                $newLogoFile = $profil->getImageFile();
                $fileName =$profil->getUsername().'.jpg';
                $newLogoFile ->move("/home/mak/ASA/public/images/users/", $fileName);
            }
            else{
                return new JsonResponse('Aucune photo choisie',200, [
                    'Content-Type' =>  'application/json'
                ]);
            }
            return new JsonResponse('Photo de profil modifié',200, [
                'Content-Type' =>  'application/json'
            ]); 
    }

    /**
     * @Route("/liste", name="events_liste", methods={"GET"})
     *  
     */
    public function liste(EvenementRepository $event,SerializerInterface $serializer): Response
    {
        $id=$this->getUser()->getGroupe()->getId();
        $events=$event->findBy(array('groupe'=>$id));

        $date= new \DateTime(); 
        $jours=7;
        $today=$date->format('yy-m-d');
        $j=$date->format('yy-m-D');
        $jour = substr($j,8);
        $lundi='Mon';
        if($jour==$lundi){
            $semaine=$date->modify('+'.$jours.'day');
            $s=$semaine->format('yy-m-d');
            $query = $this->getDoctrine()->getManager()->createQuery("SELECT u FROM App:Evenement u WHERE u.datedebut BETWEEN"."'$today'"." AND "."'$s'"." AND u.groupe ="."'$id'"."");
            $part = $query->getResult();
            $data = $serializer->serialize($part, 'json',['groups' => ['event']]);
            return new Response($data, 200, [
                'Content-Type'=>  'application/json'
            ]);
        }
        $data = $serializer->serialize($events, 'json',['groups' => ['event']]);
        return new Response($data, 200, [
            'Content-Type'=>  'application/json'
        ]);
    }
}
