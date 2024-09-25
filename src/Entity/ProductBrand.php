<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductBrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ProductBrandRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['product_brand']])]
#[ApiResource(
    security: "is_granted('ROLE_ADMIN')",
)]
class ProductBrand
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product', 'product_brand'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'brand')]
    #[Groups(['product_brand'])]
    private Collection $products;

    #[ORM\ManyToOne(targetEntity: Media::class, cascade: ['persist'])]
    #[ApiProperty(types: ['https://schema.org/image'])]
    #[Groups(['product_brand'])]
    private ?Media $logo = null;


    public function __construct()
    {
        $this->products = new ArrayCollection();
    }


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


    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }


    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setBrand($this);
        }

        return $this;
    }


    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getBrand() === $this) {
                $product->setBrand(null);
            }
        }

        return $this;
    }


    public function getLogo(): ?Media
    {
        return $this->logo;
    }


    public function setLogo(?Media $logo): static
    {
        $this->logo = $logo;

        return $this;
    }


}
