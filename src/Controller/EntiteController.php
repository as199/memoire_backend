<?php

namespace App\Controller;

use App\Entity\Entite;
use App\Entity\Departement;
use App\Entity\Utilisateur;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class EntiteController extends AbstractController
{

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;


    /**
     * InscriptionService constructor.
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     */
    public function __construct(
                                 EntityManagerInterface $entityManager,
                                 SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws ExceptionInterface
     * @throws Exception
     */
    #[Route('/api/entites', name: 'addEntites', methods:["POST"])]
    public function addEntites(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $departement= $this->entityManager->getRepository(Departement::class)->findOneBy(['id'=>(int)$data["departements"]]);
        $newEntite = $this->serializer->denormalize($data, Entite::class);
        if(isset($data['utilisateur'])){
            foreach($data['utilisateur'] as $user){
                $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id'=>(int)$user]);
                $newEntite->addUtilisateur($utilisateur);
            }
        }
        if(isset($data['responsables'])){
            $responsable = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id'=>(int)$data['responsables']]);
            $newEntite->setResponsable($responsable);

        }
        $newEntite->setDepartement($departement);
        $this->entityManager->persist($newEntite);
        $this->entityManager->flush();
        return $this->json(["data"=> $newEntite], 201);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/entites/{id}', name: 'updateEntites', methods:["PUT"])]
    public function updateEntites(Request $request, $id): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $entite = $this->entityManager->getRepository(Entite::class)->findOneBy(['id'=>$id]);
        foreach ($data as $key=> $valeur){
            $setter = 'set'. ucfirst($key);
            if(method_exists(Entite::class, $setter)){
                if($setter === "setDepartement" && isset($data["departement"]) ){
                    $entite->setDepartement($this->entityManager->getRepository(Departement::class)->findOneBy(['id'=>(int)$data["departement"]]));
                }else if($setter === "setUtilisateurs" && isset($data["utilisateurs"]) ){
                    foreach($data['utilisateurs'] as $user){
                        $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id'=>(int)$user]);
                        $entite->removeUtilisateur($utilisateur);
                        $entite->addUtilisateur($utilisateur);
                    }
                }else if($setter === "setResponsable" && isset($data["responsable"])){
                    $responsable = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id'=>(int)$data['responsable']]);
                    $entite->setResponsable($responsable);
                }
                else{
                    $entite->$setter($valeur);
                }
            }
        }
        $this->entityManager->persist($entite);
        $this->entityManager->flush();
        return $this->json(["data"=>$entite]);


    }

}
