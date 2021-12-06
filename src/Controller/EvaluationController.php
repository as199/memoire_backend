<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Entity\Departement;
use App\Entity\Mission;
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

class EvaluationController extends AbstractController
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
    #[Route('/api/evaluations', name: 'addEvaluations', methods:["POST"])]
    public function addEvaluations(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $mission = $this->entityManager->getRepository(Mission::class)->findOneBy(['id'=>(int)$data["missions"]]);
        $newEvaluation = $this->serializer->denormalize($data, Evaluation::class);
        $newEvaluation->setMission($mission);
        $newEvaluation->setStatus(true);
        $this->entityManager->persist($newEvaluation);
        $this->entityManager->flush();
        return $this->json(["data"=> $newEvaluation], 201);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/evaluations/{id}', name: 'updateEvaluations', methods:["PUT"])]
    public function updateEvaluations(Request $request, $id): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $evaluation = $this->entityManager->getRepository(Evaluation::class)->findOneBy(['id'=>(int)$id]);
        foreach ($data as $key=> $valeur){
            $setter = 'set'. ucfirst($key);
            if(method_exists(Evaluation::class, $setter)){
                if($setter === "setMission" && isset($data["mission"]) ) {
                    $evaluation->setMission($this->entityManager->getRepository(Mission::class)->findOneBy(['id' =>(int) $data["mission"]]));
                }
                else{
                    $evaluation->$setter($valeur);
                }
            }
        }
        $this->entityManager->persist($evaluation);
        $this->entityManager->flush();
        return $this->json(["data"=>$evaluation]);


    }

}
