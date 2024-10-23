<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\OpenApi\Model;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
//    uriTemplate         : "/medias/{id}",
    types               : ['https://schema.org/MediaObject'],
    operations          : [
        new Get(),
        new GetCollection(),
        new Delete(),
        new Post(
            inputFormats: ['multipart' => ['multipart/form-data']],
            openapi     : new Model\Operation(
                              requestBody: new Model\RequestBody(
                                               content: new \ArrayObject(
                                                            [
                                                                'multipart/form-data' => [
                                                                    'schema' => [
                                                                        'type' => 'object',
                                                                        'properties' => [
                                                                            'file' => [
                                                                                'type' => 'string',
                                                                                'format' => 'binary'
                                                                            ]
                                                                        ]
                                                                    ]
                                                                ]
                                                            ]
                                                        )
                                           )
                          )
        )
    ],
    outputFormats       : ['jsonld' => ['application/ld+json']],
    normalizationContext: ['groups' => ['media']],
    security            : "is_granted('ROLE_ADMIN')"
)]
class Media
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ApiProperty(writable: false, types: ['https://schema.org/contentUrl'])]
    #[Groups(['media', 'product:read', 'product_brand'])]
    public ?string $fileUrl = null;

    #[ORM\Column(length: 255)]
    #[ApiProperty(writable: false)]
    private ?string $filePath = null;

    #[Vich\UploadableField(mapping: 'media', fileNameProperty: 'filePath')]
    #[Assert\NotNull]
    #[Assert\Image]
    public ?File $file = null;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFilePath(): ?string
    {
        return $this->filePath;
    }


    public function setFilePath(?string $filePath): static
    {
        $this->filePath = $filePath;

        return $this;
    }


}
