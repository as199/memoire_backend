<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\Thematique;
use App\Entity\Utilisateur;
use App\Services\CartographieService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CartographieController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private CartographieService $cartographieService;

    public function __construct(
        EntityManagerInterface $entityManager,
        CartographieService $cartographieService
    )
    {
        $this->entityManager = $entityManager;
        $this->cartographieService = $cartographieService;
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/carto_aud/{id}', name: 'getCartoAud', methods:["GET"])]
    public function cartographieAuds($id): JsonResponse
    {
       $data = $this->cartographieService->getCartographieByAuditeur((int)$id);
        return $this->json([$data], 200);

    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/carto_ent/{id}', name: 'getCartoEnt', methods:["GET"])]
    public function cartographieEntite($id): JsonResponse
    {
        $data = $this->cartographieService->getCartographieByEntite((int)$id);
        return $this->json([$data], 200);

    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/carto_dep/{id}', name: 'getCartoDep', methods:["GET"])]
    public function cartographieDepartement($id): JsonResponse
    {
        $data = $this->cartographieService->getCartographieByDepartement((int)$id);
        return $this->json([$data], 200);

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
