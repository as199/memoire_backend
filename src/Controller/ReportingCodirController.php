<?php

namespace App\Controller;

use App\Entity\Entite;
use App\Entity\ReportingCodir;
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

class ReportingCodirController extends AbstractController
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
    #[Route('/api/reporting_codirs', name: 'addReportingCodirs', methods:["POST"])]
    public function addReportingCodirs(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $entite = $this->entityManager->getRepository(Entite::class)->findOneBy(['id'=>(int)$this->getUser()->getEntite()->getId()]);
        $newReportingCodir = $this->serializer->denormalize($data, ReportingCodir::class);
        $newReportingCodir->setEntite($entite);
        $newReportingCodir->setSemaine($this->utilsServices->getWeekend());
        $this->entityManager->persist($newReportingCodir);
        $this->entityManager->flush();
        return $this->json(["data"=> $newReportingCodir], 201);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/reporting_codirs/{id}', name: 'updateReportingCodirs', methods:["PUT"])]
    public function updateReportingCodirs(Request $request, $id): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $ReportingCodir = $this->entityManager->getRepository(ReportingCodir::class)->findOneBy(['id'=>$id]);
        foreach ($data as $key=> $valeur){
            $setter = 'set'. ucfirst($key);
            if(method_exists(ReportingCodir::class, $setter)){
                if($setter === "setEntite" && $data["entite"]){
                    $ReportingCodir->setEntite($this->entityManager->getRepository(Entite::class)->findOneBy(['id'=>(int)$this->getUser()->getEntite()->getId()]));
                }else{
                    $ReportingCodir->$setter($valeur);
                }

            }
        }
        $this->entityManager->persist($ReportingCodir);
        $this->entityManager->flush();
        return $this->json(["data"=>$ReportingCodir]);


    }

}
