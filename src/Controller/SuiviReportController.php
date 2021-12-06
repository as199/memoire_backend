<?php

namespace App\Controller;

use App\Entity\SuiviActivite;
use App\Entity\SuiviReport;
use App\Entity\Entite;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SuiviReportController extends AbstractController
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
    #[Route('/api/suivi_reports', name: 'addSuiviReports', methods:["POST"])]
    public function addSuiviReports(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $entite= $this->entityManager->getRepository(Entite::class)->findOneBy(['id'=>(int)$data["entites"]]);
        $newSuiviReport = $this->serializer->denormalize($data, SuiviReport::class);
        $newSuiviReport->setEntite($entite);
        $this->entityManager->persist($newSuiviReport);
        $this->entityManager->flush();
        return $this->json(["data"=> $newSuiviReport], 201);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/suivi_reports/{id}', name: 'updateSuiviReports', methods:["PUT"])]
    public function updateSuiviReports(Request $request, $id): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $suiviReport = $this->entityManager->getRepository(SuiviReport::class)->findOneBy(['id'=>$id]);
        foreach ($data as $key=> $valeur){
            $setter = 'set'. ucfirst($key);
            if(method_exists(SuiviReport::class, $setter)){
                if($setter === "setEntite" && isset($data["entite"]) ){
                    $suiviReport->setEntite($this->entityManager->getRepository(Entite::class)->findOneBy(['id'=>(int)$data["entite"]]));
                }
                else{
                    $suiviReport->$setter($valeur);
                }
            }
        }
        $this->entityManager->persist($suiviReport);
        $this->entityManager->flush();
        return $this->json(["data"=>$suiviReport]);


    }

}
