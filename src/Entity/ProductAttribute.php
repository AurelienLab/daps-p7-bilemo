<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ProductAttributeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Entity(repositoryClass: ProductAttributeRepository::class)]
#[ApiResource(
    operations            : [
        new Post(),
        new Get(),
        new Put(),
        new Delete(),
        new Patch()
    ],
    normalizationContext  : ['groups' => ['product-attribute:read']],
    denormalizationContext: ['groups' => ['product-attribute:write']],
    security              : "is_granted('ROLE_ADMIN')",
)]
class ProductAttribute
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'attributes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product-attribute:read', 'product-attribute:write'])]
    private ?Product $product = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product:read', 'product-attribute:read', 'product-attribute:write'])]
    private ?Attribute $attribute = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read', 'product-attribute:read', 'product-attribute:write'])]
    private ?string $value = null;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getProduct(): ?Product
    {
        return $this->product;
    }


    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }


    public function getAttribute(): ?Attribute
    {
        return $this->attribute;
    }


    public function setAttribute(?Attribute $attribute): static
    {
        $this->attribute = $attribute;

        return $this;
    }


    public function getValue(): ?string
    {
        return $this->value;
    }


    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }


    #[Groups(['product:read'])]
    #[SerializedName('name')]
    public function getAttributeName(): string
    {
        return $this->attribute->getName();
    }


}
