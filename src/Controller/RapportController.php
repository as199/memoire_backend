<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Entity\Departement;
use App\Entity\Mission;
use App\Entity\Utilisateur;
use App\Services\GestionFiles;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RapportController extends AbstractController
{

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    private GestionFiles $gestionFiles;


    /**
     * InscriptionService constructor.
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @param GestionFiles $gestionFiles
     */
    public function __construct(
                                 EntityManagerInterface $entityManager,
                                 SerializerInterface $serializer,
                                 GestionFiles $gestionFiles
    )
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->gestionFiles = $gestionFiles;
    }

    /**
     * @throws ExceptionInterface
     * @throws Exception
     */
    #[Route('/api/rapports', name: 'addRapports', methods:["POST"])]
    public function addRapports(Request $request): JsonResponse
    {
        $data =$request->request->all();
        $mission = $this->entityManager->getRepository(Mission::class)->findOneBy(['id'=>(int)$data["missions"]]);
        $file = $this->gestionFiles->getPostFile($request, 'files');
        $newRapport = $this->serializer->denormalize($data, Rapport::class);
        $newRapport->setMission($mission);
        $newRapport->setRapport($file);
        $newRapport->setStatus(true);
        $this->entityManager->persist($newRapport);
        $this->entityManager->flush();
        return $this->json(["data"=> $newRapport], 201);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/rapports/{id}', name: 'updateRapports', methods:["PUT"])]
    public function updateRapports(Request $request, $id): JsonResponse
    {
        $Rapport = $this->entityManager->getRepository(Rapport::class)->findOneBy(['id'=>(int)$id]);
        $data =  $this->gestionFiles->getPutFile($request, 'rapport');
        foreach ($data as $key=> $valeur){
            $setter = 'set'. ucfirst($key);
            if(method_exists(Rapport::class, $setter)){
                if($setter === "setMission" && isset($data["mission"]) ) {
                    $Rapport->setMission($this->entityManager->getRepository(Mission::class)->findOneBy(['id' =>(int) $data["mission"]]));
                }
                else{
                    $Rapport->$setter($valeur);
                }
            }
        }
        $this->entityManager->persist($Rapport);
        $this->entityManager->flush();
        return $this->json(["data"=>$Rapport]);


    }

}
