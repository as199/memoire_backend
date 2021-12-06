<?php

namespace App\Controller;

use App\Entity\Certification;
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

class CertificationController extends AbstractController
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
    #[Route('/api/certifications', name: 'addCertifications', methods:["POST"])]
    public function addCertifications(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $user= $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id'=>(int)$this->getUser()->getId()]);
        $newCertification = $this->serializer->denormalize($data, Certification::class);
        $newCertification->setUtilisateur($user);
        $newCertification->setObtenuAt(new DateTimeImmutable($data['obtenu']));
        $this->entityManager->persist($newCertification);
        $this->entityManager->flush();
        return $this->json(["data"=> $newCertification], 201);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/certifications/{id}', name: 'updateCertifications', methods:["PUT"])]
    public function updateCertifications(Request $request, $id): JsonResponse
    {
        $certificationUpdate = json_decode($request->getContent(),true);
        $certification = $this->entityManager->getRepository(Certification::class)->findOneBy(['id'=>$id]);
        foreach ($certificationUpdate as $key=> $valeur){
            $setter = 'set'. ucfirst($key);
            if(method_exists(Certification::class, $setter)){
                $certification->$setter($valeur);
            }
        }
        $this->entityManager->persist($certification);
        $this->entityManager->flush();
        return $this->json(["data"=>$certification]);


    }

}
