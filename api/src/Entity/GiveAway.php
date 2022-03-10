<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Message\GiveAwayCreateRequest;
use App\Repository\GiveAwayRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GiveAwayRepository::class)]
#[ApiResource(collectionOperations: [
    "post" => [
        "messenger" => "input",
        "input" => GiveAwayCreateRequest::class,
//        "messenger" => true,
        "output" => false,
        "status" => 202,
    ]
])]
class GiveAway
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date_immutable', unique: true)]
    private $date;

    #[ORM\ManyToOne(targetEntity: Participant::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $winner;

    public function __construct()
    {
        $this->setDate(new DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getWinner(): ?Participant
    {
        return $this->winner;
    }

    public function setWinner(?Participant $winner): self
    {
        $this->winner = $winner;

        return $this;
    }
}
