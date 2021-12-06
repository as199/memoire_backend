<?php

namespace App\Controller;

use App\Entity\SuiviActivite;
use App\Entity\Statut;
use App\Entity\Mission;
use App\Entity\Utilisateur;
use App\Services\UtilsServices;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SuiviActiviteController extends AbstractController
{

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    private UtilsServices $utilsServices;


    /**
     * InscriptionService constructor.
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @param UtilsServices $utilsServices
     */
    public function __construct(
                                 EntityManagerInterface $entityManager,
                                 SerializerInterface $serializer,
                                UtilsServices $utilsServices
    )
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->utilsServices = $utilsServices;
    }

    /**
     * @throws ExceptionInterface
     * @throws Exception
     */
    #[Route('/api/suivi_activites', name: 'addSuiviActivites', methods:["POST"])]
    public function addSuiviActivites(Request $request): JsonResponse
    {
        $data =json_decode($request->getContent(),true);
        $mission = $this->entityManager->getRepository(Mission::class)->findOneBy(['id'=>(int)$data["missions"]]);
        $statut = $this->entityManager->getRepository(Statut::class)->findOneBy(['id'=>(int)$data["statuts"]]);
        $week = $this->utilsServices->getWeekend();
        $newSuiviActivite = $this->serializer->denormalize($data, SuiviActivite::class);
        $newSuiviActivite->setMission($mission);
        $newSuiviActivite->setSemaine($week);
        $newSuiviActivite->setStatut($statut);
        $this->entityManager->persist($newSuiviActivite);
        $this->entityManager->flush();
        return $this->json(["data"=> $newSuiviActivite], 201);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/suivi_activites/{id}', name: 'updateSuiviActivites', methods:["PUT"])]
    public function updateSuiviActivites(Request $request, $id): JsonResponse
    {
        $SuiviActivite = $this->entityManager->getRepository(SuiviActivite::class)->findOneBy(['id'=>(int)$id]);
        $data =  json_decode($request->getContent(),true);
        foreach ($data as $key=> $valeur){
            $setter = 'set'. ucfirst($key);
            if(method_exists(SuiviActivite::class, $setter)){
                if($setter === "setMission" && isset($data["mission"]) ) {
                    $SuiviActivite->setMission($this->entityManager->getRepository(Mission::class)->findOneBy(['id' =>(int) $data["mission"]]));
                }else if($setter === "setStatut" && isset($data["statut"]) ) {
                    $SuiviActivite->setStatut($this->entityManager->getRepository(Statut::class)->findOneBy(['id' =>(int) $data["statut"]]));
                }
                else{
                    $SuiviActivite->$setter($valeur);
                }
            }
        }
        $this->entityManager->persist($SuiviActivite);
        $this->entityManager->flush();
        return $this->json(["data"=>$SuiviActivite]);


    }

}
