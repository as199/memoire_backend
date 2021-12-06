<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\Thematique;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CompetenceController extends AbstractController
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
     */
    #[Route('/api/competences', name: 'addCompetences', methods:["POST"])]
    public function addCompetences(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $thematique= (isset($data['thematiques']) and $data['thematiques'] !== "")?$this->entityManager->getRepository(Thematique::class)->findOneBy(['id'=>(int)$data['thematiques']]): null;
        $newCompetence = $this->serializer->denormalize($data, Competence::class);
        $newCompetence->setThematique($thematique);
        $newCompetence->setStatus(true);
        $this->entityManager->persist($newCompetence);
        $this->entityManager->flush();
        return $this->json(["data"=> $newCompetence], 201);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/competences/{id}', name: 'updateCompetence', methods:["PUT"])]
    public function UpdateCompetence(Request $request, $id): JsonResponse
    {
        $competenceUpdate = json_decode($request->getContent(),true);
        $competence = $this->entityManager->getRepository(Competence::class)->findOneBy(['id'=>$id]);
        foreach ($competenceUpdate as $key=> $valeur){
            $setter = 'set'. ucfirst($key);
            if(method_exists(Competence::class, $setter)){
                if($setter=='setThematique' && isset($competenceUpdate['thematique'])){
                    $competence->setThematique($this->entityManager->getRepository(Thematique::class)->findOneBy(['id'=>(int)$competenceUpdate['thematique']]));
                }else{
                    $competence->$setter($valeur);
                }
            }
        }
        $this->entityManager->persist($competence);
        $this->entityManager->flush();
        return $this->json(["data"=>$competence]);


    }

}
