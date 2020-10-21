<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Groupe;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\Exception\FormSizeFileException;
use App\Form\ResetType;

class InscriptionController extends AbstractController
{
   /**
     * @Route("/inscription", name="inscription", methods={"GET","POST"})
     * 
     */
    public function inscription(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,ValidatorInterface $validator): Response
    {

        $utilisateur = new User();
        $groupe= new Groupe();

        $form = $this->createForm(UserType::class, $utilisateur);
        $form->handleRequest($request);
        $data=$request->request->all();
        $file=$request->files->all()['imageFile'];

        $form->submit($data);

        $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
        $utilisateur->setPassword($hash);
        $groupe->setNomgroupe($utilisateur->getEmail());
        $entityManager->persist($groupe);
        $utilisateur->setImageFile($file);
        $utilisateur->setGroupe($groupe);
        $utilisateur->setRoles([$utilisateur->getRole()]);
        $entityManager->persist($utilisateur);
        $entityManager->flush(); 
       
        return new JsonResponse('Compte crée, Bienvenue'.$utilisateur->getUsername(),200, [
            'Content-Type' => 'application/json'
        ]);
    }
    /**
     * @Route("/reset", name="reset", methods={"POST"})
     * 
     */
    public function Resetpwd(Request $request)
    {
        return $this->Reset($request, false);
    }
    private function Reset(Request $request, $clearMissing):Response
    
    {
        $utilisateur = new User();
        $form = $this->createForm(UserType::class, $utilisateur ,array(
            'action'=>$this->generateUrl('reset'),
            'method'=>'POST',
        ));
        $form->handleRequest($request);
        $data=$request->request->all();
        $form->submit($data, $clearMissing);

        $profil = $this->getDoctrine()->getRepository(User::class)->find($utilisateur->getUsername()); 
        var_dump($profil);die();

        if (empty($profil)) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $form1 = $this->createForm(UserType::class, $profil ,array(
            'action'=>$this->generateUrl('reset', array('id'=>$profil->getId())),
            'method'=>'POST',
        ));
        $form1->handleRequest($request);
        $data=$request->request->all();

        $form->submit($data, $clearMissing);
        $em = $this->getDoctrine()->getManager();
        $em->persist($profil);
        $em->flush();
        return new JsonResponse('Profil mis à jour',200, 
            ['Content-Type' => 'application/json'
            ]);      
    }
}
