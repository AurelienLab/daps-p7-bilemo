<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['product']])]
#[ApiResource]
class Product
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product', 'product_brand'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product', 'product_brand'])]
    private ?string $reference = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product', 'product_brand'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product', 'product_brand'])]
    private ?string $ean_code = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[Groups(['product'])]
    private ?ProductBrand $brand = null;

    /**
     * @var Collection<int, ProductImage>
     */
    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['product', 'product_brand'])]
    private Collection $images;


    public function __construct()
    {
        $this->images = new ArrayCollection();
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
        return $this->ean_code;
    }


    public function setEanCode(?string $ean_code): static
    {
        $this->ean_code = $ean_code;

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
     * @return Collection<int, ProductImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }


    public function addImage(ProductImage $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProduct($this);
        }

        return $this;
    }


    public function removeImage(ProductImage $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }


}
