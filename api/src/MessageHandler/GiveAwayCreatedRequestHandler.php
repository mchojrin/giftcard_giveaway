<?php

namespace App\MessageHandler;

use App\Entity\GiveAway;
use App\Entity\Participant;
use App\Message\GiveAwayCreateRequest;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class GiveAwayCreatedRequestHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(GiveAwayCreateRequest $giveAwayCreateRequest)
    {
        // do something with your message
        $qb = $this->entityManager->createQueryBuilder();
        $q = $qb->from(Participant::class, 'p')
            ->select('p.id')
            ->getQuery()
        ;
        $ids = $q->getResult(AbstractQuery::HYDRATE_SCALAR);
    }
}
