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

class DepartementController extends AbstractController
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
    #[Route('/api/departements', name: 'addDepartements', methods:["POST"])]
    public function addDepartements(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $newDepartement= $this->serializer->denormalize($data, Departement::class);
        $responsable = (isset($data["responsables"]) && $data["responsables"]!== "")?$this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id'=>(int)$data['responsables']]):null;
        $newDepartement->setResponsable($responsable);
        $newDepartement->setStatus(true);
        $this->entityManager->persist($newDepartement);
        $this->entityManager->flush();
        return $this->json(["data"=> $newDepartement], 201);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/departements/{id}', name: 'updateDepartements', methods:["PUT"])]
    public function updateDepartements(Request $request, $id): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $departement = $this->entityManager->getRepository(Departement::class)->findOneBy(['id'=>$id]);
        foreach ($data as $key=> $valeur){
            $setter = 'set'. ucfirst($key);
            if(method_exists(Entite::class, $setter)){
                if($setter === "setResponsable" && isset($data["responsable"]) ){
                    $departement->setResponsable($this->entityManager->getRepository(Departement::class)->findOneBy(['id'=>(int)$data["responsable"]]));
                }
                else{
                    $departement->$setter($valeur);
                }
            }
        }
        $this->entityManager->persist($departement);
        $this->entityManager->flush();
        return $this->json(["data"=>$departement]);


    }

    #[Route('/api/departements/entites/{id}', name: 'getEntites', methods:["GET"])]
    public function getEntitesByDepartements($id): JsonResponse
    {
        $entites = $this->entityManager->getRepository(Entite::class)->findBy(['departement'=>(int)$id]);
        $data = [];
        $i=1;
        foreach($entites as $entite){
            $data[$i]['id_entite'] = $entite->getId();
            $data[$i]['libelle_entite'] = $entite->getLibelle();
            $i++;
        }
        return $this->json(["data"=> $data], 201);
    }

    #[Route('/api/departements/utilisateurs/{id}', name: 'getUtilisateurs', methods:["GET"])]
    public function getUtilisateursByDepartement($id): JsonResponse
    {
        $entites = $this->entityManager->getRepository(Utilisateur::class)->findBy(['departement'=>$id]);
        $data = [];
        $i=1;
        foreach($entites as $entite){
            $data[$i]['id_user'] = $entite->getId();
            $data[$i]['nomcomplet'] = $entite->getNomComplet();
            $i++;
        }
        return $this->json(["data"=> $data], 201);
    }
}
