<?php

namespace App\Controller;

use App\Entity\Certification;
use App\Entity\Diplome;
use App\Entity\Thematique;
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

class DiplomeController extends AbstractController
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
    #[Route('/api/diplomes', name: 'addDiplomes', methods:["POST"])]
    public function addDiplomes(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $user= $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id'=>(int)$this->getUser()->getId()]);
        $newDiplome = $this->serializer->denormalize($data, Diplome::class);
        $newDiplome->setUtilisateur($user);
        $newDiplome->setObtenuAt(new DateTimeImmutable($data['obtenu']));
        $this->entityManager->persist($newDiplome);
        $this->entityManager->flush();
        return $this->json(["data"=> $newDiplome], 201);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/diplomes/{id}', name: 'updateDiplomes', methods:["PUT"])]
    public function updateDiplomes(Request $request, $id): JsonResponse
    {
        $diplomeUpdate = json_decode($request->getContent(),true);
        $diplome = $this->entityManager->getRepository(Diplome::class)->findOneBy(['id'=>$id]);
        foreach ($diplomeUpdate as $key=> $valeur){
            $setter = 'set'. ucfirst($key);
            if(method_exists(Diplome::class, $setter)){
                    $diplome->$setter($valeur);
            }
        }
        $this->entityManager->persist($diplome);
        $this->entityManager->flush();
        return $this->json(["data"=>$diplome]);


    }

}
