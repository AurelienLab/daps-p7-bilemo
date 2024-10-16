<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\CreateProvider;
use App\Entity\Trait\Timestampable;
use App\Repository\UserRepository;
use App\State\TimestampableProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    uriTemplate           : "/customers/{customerId}/users/{id}",
    operations            : [
        new Get(),
        new Patch(),
        new Delete()
    ],
    uriVariables          : [
        'customerId' => new Link(
            toProperty: 'customer',
            fromClass : Customer::class,
            security  : "is_granted('CUSTOMER_MANAGE_USERS', customer)"
        ),
        'id' => new Link(
            fromClass: User::class
        ),
    ],
    normalizationContext  : ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:put']],
    processor             : TimestampableProcessor::class,
)]
#[ApiResource(
    uriTemplate : "/customers/{customerId}/users",
    operations  : [
        new GetCollection(),
        new Post(
            provider: CreateProvider::class,
        ),
    ],
    uriVariables: [
        'customerId' => new Link(
            toProperty: 'customer',
            fromClass : Customer::class,
            security  : "is_granted('CUSTOMER_MANAGE_USERS', customer)"
        )
    ],
    processor   : TimestampableProcessor::class,
)]
#[ApiResource(
    security : "is_granted('ROLE_ADMIN')",
    processor: TimestampableProcessor::class,
)]
class User implements TimestampableInterface
{


    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user:read", "user:put"])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user:read", "user:put"])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user:read", "user:put"])]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["user:read", "user:put"])]
    private ?string $phone = null;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private Customer $customer;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFirstname(): ?string
    {
        return $this->firstname;
    }


    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }


    public function getLastname(): ?string
    {
        return $this->lastname;
    }


    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }


    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function getPhone(): ?string
    {
        return $this->phone;
    }


    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }


    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }


    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }


}
