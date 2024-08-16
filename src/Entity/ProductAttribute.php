<?php

namespace App\Entity;

use App\Repository\ProductAttributeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Entity(repositoryClass: ProductAttributeRepository::class)]
class ProductAttribute
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'attributes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Attribute $attribute = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product'])]
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


    #[Groups(['product'])]
    #[SerializedName('name')]
    public function getAttributeName(): string
    {
        return $this->attribute->getName();
    }


}
