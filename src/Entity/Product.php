<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ProductRepository;
use App\State\ProductProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\MaxDepth;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    operations            : [
        new Get(),
        new GetCollection(),
    ],
    normalizationContext  : ['groups' => ['product:read']],
    denormalizationContext: ['groups' => ['product:write']],
)]
#[ApiResource(
    operations            : [
        new Post(),
        new Put(),
        new Delete(),
        new Patch(),
    ],
    normalizationContext  : ['groups' => ['product:read']],
    denormalizationContext: ['groups' => ['product:write']],
    security              : "is_granted('ROLE_ADMIN')",
)]
class Product
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product:read', 'product_brand'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:write', 'product:read', 'product_brand'])]
    private ?string $reference = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:write', 'product:read', 'product_brand'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product:write', 'product:read', 'product_brand'])]
    private ?string $eanCode = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[Groups(['product:write', 'product:read'])]
    private ?ProductBrand $brand = null;

    /**
     * @var Collection<int, ProductAttribute>
     */
    #[ORM\OneToMany(targetEntity: ProductAttribute::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['product:read'])]
    private Collection $attributes;

    /**
     * @var Collection<int, Media>
     */
    #[ORM\ManyToMany(targetEntity: Media::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['product:read', 'product:write'])]
    private Collection $medias;


    public function __construct()
    {
        $this->attributes = new ArrayCollection();
        $this->medias = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getReference(): ?string
    {
        return $this->reference;
    }


    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
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


    public function getEanCode(): ?string
    {
        return $this->eanCode;
    }


    public function setEanCode(?string $ean_code): static
    {
        $this->eanCode = $ean_code;

        return $this;
    }


    public function getBrand(): ?ProductBrand
    {
        return $this->brand;
    }


    public function setBrand(?ProductBrand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }


    /**
     * @return Collection<int, ProductAttribute>
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }


    public function addAttribute(ProductAttribute $attribute): static
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes->add($attribute);
            $attribute->setProduct($this);
        }

        return $this;
    }


    public function removeAttribute(ProductAttribute $attribute): static
    {
        if ($this->attributes->removeElement($attribute)) {
            // set the owning side to null (unless already changed)
            if ($attribute->getProduct() === $this) {
                $attribute->setProduct(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, Media>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }


    public function addMedia(Media $media): static
    {
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
        }

        return $this;
    }


    public function removeMedia(Media $media): static
    {
        $this->medias->removeElement($media);

        return $this;
    }


}
