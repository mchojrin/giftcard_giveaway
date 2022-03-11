<?php

namespace App\Command;

use App\Entity\GiveAway;
use App\Entity\Participant;
use DateTimeImmutable;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:select-winner',
    description: 'Select the winner for today\'s giveaway among participants',
)]
class SelectWinnerCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
//        $this
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
//        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($todayGiveAway = $this->getTodayGiveAway()) {
            $io->error('Today\'s giveaway already has a winner: "'.$todayGiveAway->getWinner().'"');

            return Command::INVALID;
        }

        $winner = $this->selectWinner();

        $io->writeln('Today\'s winner is "'.$winner->getName().'"');

        $giveAway = new GiveAway();
        $giveAway->setWinner($winner);
        $this->entityManager->persist($giveAway);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }

    /**
     * @return mixed|object|null
     */
    private function selectWinner(): mixed
    {
        $queryBuilder = $this->entityManager
            ->createQueryBuilder();
        $participantsIdsQuery = $queryBuilder
            ->from(Participant::class, 'p')
            ->select('p.id')
            ->getQuery();
        $participantsIds = $participantsIdsQuery
            ->getResult(AbstractQuery::HYDRATE_SCALAR);

        $winnerId = $participantsIds[array_rand($participantsIds)];

        $winner = $this->entityManager
            ->getRepository(Participant::class)
            ->find($winnerId);
        return $winner;
    }

    /**
     * @return mixed|object|null
     */
    private function getTodayGiveAway(): mixed
    {
        $todayGiveAway = $this->entityManager
            ->getRepository(GiveAway::class)
            ->findOneBy([
                'date' => new DateTimeImmutable()
            ]);
        return $todayGiveAway;
    }
}
