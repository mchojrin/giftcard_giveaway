<?php

namespace App\Command;

use App\Reloadly\Client;
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

        $this->client->sendGiftCardTo('mchojrin@gmail.com');

        $io->success('Giftcards sent!');

        return Command::SUCCESS;
    }
}
