<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Entity\Entite;
use App\Entity\Fonction;
use App\Entity\Utilisateur;
use App\Repository\FonctionRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UtilisateurController extends AbstractController
{

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $encoder;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;


    /**
     * InscriptionService constructor.
     * @param UserPasswordHasherInterface $encoder
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     */
    public function __construct( UserPasswordHasherInterface $encoder,
                                 EntityManagerInterface $entityManager,
                                 SerializerInterface $serializer
    )
    {
        $this->encoder =$encoder;
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/utilisateurs', name: 'addUtilisateur', methods:["POST"])]
    public function addUtilisateur(Request $request): JsonResponse
    {
        $userReq =json_decode($request->getContent(),true);
        $fonction = $userReq['profil'] !== ""?$this->entityManager->getRepository(Fonction::class)->findOneBy(['id'=>(int)$userReq['profil']]): null;
        $departement = $userReq['departements'] !== ""? $this->entityManager->getRepository(Departement::class)->findOneBy(['id'=>(int)$userReq['departements']]): null;
        $service = (isset($userReq['service']) and $userReq['service'] !== "")?$this->entityManager->getRepository(Entite::class)->findOneBy(['id'=>(int)$userReq['service']]): null;
        $newUser = $this->serializer->denormalize($userReq, Utilisateur::class);
        $newUser->setFonction($fonction);
        $newUser->setDepartement($departement);
        $newUser->setEntite($service);
        $newUser->setStatus(true);
        $newUser->setPassword($this->encoder->hashPassword($newUser, $userReq['password']));
        $this->entityManager->persist($newUser);
        $this->entityManager->flush();
        return $this->json(["data"=> $newUser], 201);
    }

    /**
     * @throws \Exception
     */
    #[Route('/api/utilisateurs/{id}', name: 'updateUtilisateur', methods:["PUT"])]
    public function UpdateUser(Request $request, $id): JsonResponse
    {
        $userUpdate = json_decode($request->getContent(),true);;
        $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id'=>$id]);
        foreach ($userUpdate as $key=> $valeur){
            $setter = 'set'. ucfirst($key);
            if(method_exists(Utilisateur::class, $setter)){
                if($setter=='setProfil' && isset($userUpdate['profil'])){
                    $utilisateur->setFonction($this->entityManager->getRepository(Fonction::class)->findOneBy(['id'=>(int)$userUpdate['profil']]));
                }else if($setter=='setDepartement' && isset($userUpdate['departement'])){
                    $utilisateur->setDepartement($this->entityManager->getRepository(Departement::class)->findOneBy(['id'=>(int)$userUpdate['departement']]));
                }
                else if($setter=='setEntite' && isset($userUpdate['entite'])){
                    $utilisateur->setEntite($this->entityManager->getRepository(Entite::class)->findOneBy(['id'=>(int)$userUpdate['entite']]));
                }
                else if($setter=='setPassword' && isset($userUpdate['password'])){
                    $utilisateur->setPassword($this->encoder->hashPassword($utilisateur,$userUpdate['password']));
                }else if($setter=='setEntreeAt' && isset($userUpdate['entreeAt'])){
                    $utilisateur->setEntreeAt(new \DateTimeImmutable($userUpdate['entreeAt']));
                }else if($setter=='setSortieAt' && isset($userUpdate['sortieAt'])){
                    $utilisateur->setSortieAt(new \DateTimeImmutable($userUpdate['sortieAt']));
                }
                else{
                    $utilisateur->$setter($valeur);
                }
            }
        }
        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();
        return $this->json(["data"=>$utilisateur],200);


    }

}
