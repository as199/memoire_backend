<?php

namespace App\Controller;

use App\Entity\Entite;
use App\Entity\Mission;
use App\Entity\Thematique;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class MissionController extends AbstractController
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
    #[Route('/api/missions', name: 'addMissions', methods:["POST"])]
    public function addMissions(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $responable= (isset($data['responables']) and $data['responables'] !== "")?$this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id'=>(int)$data['responables']]): null;
        $entite= (isset($data['entites']) and $data['entites'] !== "")?$this->entityManager->getRepository(Entite::class)->findOneBy(['id'=>(int)$data['entites']]): null;
        $utilisateurs= (isset($data['utilisateur']) and $data['utilisateur'] !== "")?$data['utilisateur']: null;
        $newMission = $this->serializer->denormalize($data, Mission::class);
        foreach($utilisateurs as $user){
            $newMission->addUtilisateur($this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id' => (int)$user]));
        }
        $newMission->setResponsable($responable);
        $newMission->setEntite($entite);
        $newMission->setStatus(true);
        $this->entityManager->persist($newMission);
        $this->entityManager->flush();
        return $this->json(["data"=> $newMission], 201);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/missions/{id}', name: 'updateMissions', methods:["PUT"])]
    public function UpdateMissions(Request $request, $id): JsonResponse
    {
        $missionUpdate = json_decode($request->getContent(),true);
        $mission = $this->entityManager->getRepository(Mission::class)->findOneBy(['id'=>$id]);
        foreach ($missionUpdate as $key=> $valeur){
            $setter = 'set'. ucfirst($key);
            if(method_exists(Mission::class, $setter)){
                if($setter=='setResponsable' && isset($missionUpdate['responsable'])){
                    $mission->setResponsable($this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id'=>(int)$missionUpdate['responsable']]));
                }else if($setter=='setEntite' && isset($missionUpdate['entite'])){
                    $mission->setEntite($this->entityManager->getRepository(Entite::class)->findOneBy(['id'=>(int)$missionUpdate['entite']]));
                }else if($setter=='setDebutAt' && isset($missionUpdate['debutAt'])){
                    $mission->setDebutAt(new \DateTimeImmutable($missionUpdate['debutAt']));
                }else if($setter=='setFinAt' && isset($missionUpdate['finAt'])){
                    $mission->setFinAt(new \DateTimeImmutable($missionUpdate['finAt']));
                }
                else if($setter=='setUtilisateurs' && isset($missionUpdate['utilisateurs'])) {
                    foreach($missionUpdate['utilisateurs'] as $user){
                        $utilisateur = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id' => (int)$user]);
                        $mission->removeUtilisateur($utilisateur);
                        $mission->addUtilisateur($utilisateur);
                    }
                }else{
                    $mission->$setter($valeur);
                }
            }
        }
        $this->entityManager->persist($mission);
        $this->entityManager->flush();
        return $this->json(["data"=>$mission]);


    }


    /**
     * @throws Exception
     */
    #[Route('/api/mes_missions', name: 'myMissions', methods:["GET"])]
    public function myMissions(): JsonResponse
    {
        $data=[];
        $id = $this->getUser()->getId();
        $missions= $this->entityManager->getRepository(Mission::class)->findAll();
        if(!empty($mission)){
            foreach ($missions as $mission) {
                if($mission->getUtilisateurs()->getId() === (int)$id) {
                    $data[]['id'] = $mission->getId();
                    $data[]['libelle'] = $mission->getLibelle();
                    $data[]['annee'] = $mission->getAnnee();
                    $data[]['debutAt'] = $mission->getDebutAt();
                    $data[]['debutAt'] = $mission->getDebutAt();
                    $data[]['debutAt'] = $mission->getDebutAt();
                    $data[]['nbreJrReel'] = $mission->getNbreJrReel();
                    $data[]['nbreJrPrevu'] = $mission->getNbreJrPrevu();
                    $data[]['impact'] = $mission->getNimpact();
                    $data[]['gravite'] = $mission->getGravite();
                }
            }
        }

         return $this->json(["data"=>$data]);


    }

}
