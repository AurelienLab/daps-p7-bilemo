<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AttributeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AttributeRepository::class)]
#[ApiResource(security: "is_granted('ROLE_ADMIN')")]
class Attribute
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product'])]
    private ?string $name = null;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getName(): ?string
    {
        return $this->name;
    }


    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }


}
