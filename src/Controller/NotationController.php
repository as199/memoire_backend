<?php

namespace App\Controller;

use App\Entity\Notation;
use App\Entity\Competence;
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

class NotationController extends AbstractController
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
    #[Route('/api/notations', name: 'addNotations', methods:["POST"])]
    public function addNotations(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $user= isset($data['utilisateurs'])?$this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id'=>(int)$data["utilisateurs"]]):null;
        $competence= isset($data['competences'])?$this->entityManager->getRepository(Competence::class)->findOneBy(['id'=>(int)$data["competences"]]):null;
        $newNotation = $this->serializer->denormalize($data, Notation::class);
        $newNotation->setUtilisateur($user);
        $newNotation->setPeriode(new \DateTime($data['periodes']));
        $newNotation->setCompetence($competence);
        $this->entityManager->persist($newNotation);
        $this->entityManager->flush();
        return $this->json(["data"=> $newNotation], 201);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/notations/{id}', name: 'updateNotations', methods:["PUT"])]
    public function updateNotations(Request $request, $id): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $notation = $this->entityManager->getRepository(Notation::class)->findOneBy(['id'=>$id]);
        foreach ($data as $key=> $valeur){
            $setter = 'set'. ucfirst($key);
            if(method_exists(Notation::class, $setter)){
                if($setter == "setUtilisateur" && isset($data["utilisateur"])){
                    $notation->setUtilisateur($this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id'=>$data["utilisateur"]]));
                }else if($setter == "setCompetence" && isset($data["competence"])){
                    $notation->setCompetence($this->entityManager->getRepository(Competence::class)->findOneBy(['id'=>$data["competence"]]));
                }else if($setter == "setPeriode" && isset($data["periode"])){
                    $notation->setPeriode(new \DateTime($data['periode']));
                }else{
                    $notation->$setter($valeur);
                }
            }
        }
        $this->entityManager->persist($notation);
        $this->entityManager->flush();
        return $this->json(["data"=>$notation]);


    }

}
