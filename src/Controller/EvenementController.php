<?php

namespace App\Controller;

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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="evenement_index", methods={"GET"})
     */
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="evenement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(Evenement1Type::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index');
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evenement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evenement $evenement): Response
    {
        $form = $this->createForm(Evenement1Type::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_index');
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evenement $evenement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_index');
    }

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
}
