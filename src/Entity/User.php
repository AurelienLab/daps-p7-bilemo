<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\State\CreateProvider;
use App\Entity\Trait\Timestampable;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    uriTemplate : "/customers/{customerId}/users/{id}",
    operations  : [new Get(), new Patch(), new Put(), new Delete()],
    uriVariables: [
        'customerId' => new Link(
            toProperty: 'customer',
            fromClass : Customer::class,
            security  : "is_granted('CUSTOMER_MANAGE_USERS', customer)"
        ),
        'id' => new Link(
            fromClass: User::class,
        ),
    ],
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
)]
#[ApiResource(security: "is_granted('ROLE_ADMIN')")]
class User implements TimestampableInterface
{


    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Customer $customer = null;


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
