<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Enfant;
use App\Entity\Groupe;
use App\Form\UserType;
use App\Form\LoginType;
use App\Form\EnfantType;
use App\Form\ProfilType;
use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\Exception\FormSizeFileException;


/**
 * @Route("/api")
 */
class UserController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
    $this->passwordEncoder = $passwordEncoder;
    }
        /**
     *@Route("/login", name="connexion", methods={"POST"})
     * @return JsonResponse
     * @param Request $request
     */

    public function login(Request $request, JWTEncoderInterface $JWTEncoder,AuthenticationUtils $authenticationUtils)
    
    {

        $utilisateur = new User();
        $form = $this->createForm(LoginType::class, $utilisateur);
        $form->handleRequest($request);
        $data=$request->request->all();
        $form->submit($data);
        $form->handleRequest($request);
        $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(array('username'=>$utilisateur->getUsername()));
        if($user==null ){
            return new JsonResponse("Nom d'utilisateur ou mot de passe erroné réessayer",500, [
                'Content-Type'=>  'application/json'
            ]);
                }else{
            $pass=$this->passwordEncoder->isPasswordValid($user,$utilisateur->getPassword());
            if($pass==false){
                return new JsonResponse("Nom d'utilisateur ou mot de passe erroné réessayer",500, [
                    'Content-Type'=>  'application/json'
                ]);
            }
            $token = $JWTEncoder->encode([
                'roles'=>$user->getRoles(),
                'username' => $user->getUsername(),  
            ]);
        return new JsonResponse(['token' =>$token]);
        }   
    }
    /**
     * @Route("/login/inscription", name="inscription", methods={"GET","POST"})
     * 
     */
    public function inscription(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,ValidatorInterface $validator): Response
    {

        $utilisateur = new User();
        $groupe= new Groupe();

        $form = $this->createForm(UserType::class, $utilisateur);
        $form->handleRequest($request);
        $data=$request->request->all();

        $form->submit($data);

        $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
        $utilisateur->setPassword($hash);
        $groupe->setNomgroupe($utilisateur->getEmail());
        $entityManager->persist($groupe);
        $utilisateur->setGroupe($groupe);
        $utilisateur->setRoles([$utilisateur->getRole()]);
        $entityManager->persist($utilisateur);
        $entityManager->flush(); 
       
        return new JsonResponse('Compte crée, Bienvenue'.$utilisateur->getUsername(),200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/{id}/profil", name="profil", methods={"PATCH"})
     * 
     */
    public function patchProfil(Request $request)
    {
        return $this->updatePlace($request, false);
    }
    private function updatePlace(Request $request, $clearMissing):Response
    {
        $profil = $this->getDoctrine()->getRepository(User::class)->find($request->get('id')); 

        if (empty($profil)) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(ProfilType::class, $profil ,array(
            'action'=>$this->generateUrl('profil', array('id'=>$profil->getId())),
            'method'=>'POST',
        ));
        $form->handleRequest($request);
        $data=$request->request->all();

        $form->submit($data, $clearMissing);
        $em = $this->getDoctrine()->getManager();
        $em->persist($profil);
        $em->flush();
        return new JsonResponse('Profil mis à jour',200, 
            ['Content-Type' => 'application/json'
            ]);      
    }
  

    /**
     * @Route("/ajout", name="ajout", methods={"GET","POST"})
     * 
     */
    public function ajout(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,ValidatorInterface $validator): Response
    {

        $g=$this->getUser()->getGroupe();
        $utilisateur = new User();
        $form = $this->createForm(UserType::class, $utilisateur);
        $form->handleRequest($request);
        $data=$request->request->all();
        $file=$request->files->all()['imageFile'];
        $form->submit($data);
        $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
        $utilisateur->setPassword($hash);
        $utilisateur->setGroupe($g);
        $utilisateur->setRoles([$utilisateur->getRole()]);
        $utilisateur->setImageFile($file);
        $entityManager->persist($utilisateur);
        if($utilisateur->getRole()=='ROLE_ENFANT'){
            $enfant = new Enfant();
            $form1 = $this->createForm(EnfantType::class, $enfant);
            $form1->handleRequest($request);
            $form1->submit($data);
            $enfant->setUser($utilisateur);
            if($enfant->getEtablissement()==null|| $enfant->getNiveauscolaire()==null){

                $enfant->setNiveauscolaire('non mentionné');
                $enfant->setEtablissement('non mentionné');
            }
        
            $entityManager->persist($enfant);

        }
        $entityManager->flush();
            
        return new JsonResponse('membre ajouté avec succés',200, [
            'Content-Type' =>  'application/json'
        ]);
    }

    
   
    /**
     * @Route("/evenement", name="evenement", methods={"GET","POST"})
     * 
     */
    public function evenement(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,ValidatorInterface $validator): Response
    {
        $g=$this->getUser()->getGroupe();
        $event = new Evenement();
        $form = $this->createForm(EvenementType::class, $event);
        $form->handleRequest($request);
        $data=$request->request->all();
        $form->submit($data);
        if($event->getDescriptif()==null){
            $event->setDecriptif($event->getLibelle());   
        }
        if($event->getDatefin()==null){
            $event->setDatefin($event->getDatedebut());   
        }
        if($event->getheuredebut()==null){
            $event->setheuredebut('00:00');   
        }else{
            if($event->getheurefin()==null){
                $event->setheurefin($event->getheuredebut());   
            }
        }
        if($event->getheurefin()==null){
            $event->setheurefin('00:00');   
        }
        $event->setGroupe($g);   
        $entityManager->persist($event);
        $entityManager->flush();
            
        return new JsonResponse('evenement ajouté avec succés',200, [
            'Content-Type' =>  'application/json'
        ]);
    }
    /**
     * @Route("/users", name="users_liste", methods={"GET"})
     *  
     */
    public function users(UserRepository $user,SerializerInterface $serializer): Response
    {
       
        $id=$this->getUser()->getGroupe()->getId();
        $users=$user->findBy(array('groupe'=>$id));
        $data = $serializer->serialize($users, 'json',['groups' => ['users']]);
        return new Response($data, 200, [
            'Content-Type'=>  'application/json'
        ]);
    }

    /**
     * @Route("/{id}/pp", name="picture_show", methods={"GET"})
     */
    public function pp(Request $request, User $utilisateur): Response
    {
        $filepath = "/home/mak/ASA/public/images/users/".$utilisateur->getImageName();
        $filename = $utilisateur->getImageName();
        
        $response = new Response();
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $filename);
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/png');
        $response->setContent(file_get_contents($filepath));
      
        return $response;      
    }
    /**
     * @Route("/pp", name="pictures", methods={"GET"})
     */
    public function pictures(UserRepository $utilisateur)
    {
        $user=$utilisateur->findAll();

            $resp=array();
          for($i=0;$i<count($user);$i++){
            $response = new Response();

            if($user[$i]->getImageName()==''){
                echo'null';
            }   
            $filepath = "/home/mak/ASA/public/images/users/".$user[$i]->getImageName();
            $filename = $user[$i]->getImageName();
            $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $filename);
            $response->headers->set('Content-Disposition', $disposition);
            $response->headers->set('Content-Type', 'image/png');
            $response->setContent(file_get_contents($filepath));  
            $resp[]= $response;
          }
          //return $response;
            
          return new Response(json_encode($resp));        
    }

   
}