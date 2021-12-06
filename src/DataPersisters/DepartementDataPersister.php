<?php

namespace App\DataPersisters;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Departement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class DepartementDataPersister implements ContextAwareDataPersisterInterface
{


    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager=$manager;
    }
    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Departement;
    }

    /**
     * @inheritDoc
     */
    public function persist($data, array $context = [])
    {
        $data->setLibelle($data->getLibelle());
        $data->setStatus(true);
        $this->manager->persist($data);
        $this->manager->flush();
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function remove($data, array $context = [])
    {
        $status = $data->getStatus();
        $data->setStatus(!$status);
        $this->manager->persist($data);
        $this->manager->flush();
        return new JsonResponse("Archivée avec success!",200,[],true);
    }
}