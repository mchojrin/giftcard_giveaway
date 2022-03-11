<?php

namespace App\Command;

use App\Entity\GiveAway;
use App\Reloadly\Client;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:send-giftcard',
    description: 'Send the giftcard to the winners',
)]
class SendGiftcardCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private Client $client;

    public function __construct(EntityManagerInterface $entityManager, Client $client, string $name = null)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->client = $client;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $availableGiveAways = $this->getAvailableGiveAways();

        foreach ($availableGiveAways as $giveAway) {
            $winnerEmail = $giveAway->getWinner()->getEmail();
            $this->client->sendGiftCardTo($winnerEmail);
            $io->writeln('Giftcard sent to '.$winnerEmail);
            $this->markAsSent($giveAway);
        }

        $this->entityManager->flush();

        $io->success('Giftcards sent!');

        return Command::SUCCESS;
    }

    private function getAvailableGiveAways() : array
    {
        return $this->entityManager->getRepository(GiveAway::class)
            ->findBy([
                'notified_at' => null,
            ])
            ;
    }

    private function markAsSent(GiveAway $giveAway) : void
    {
        $giveAway->setNotifiedAt(new DateTimeImmutable());
    }
}
