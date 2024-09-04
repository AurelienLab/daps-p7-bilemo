<?php

namespace App\Serializer;

use App\Entity\Media;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Vich\UploaderBundle\Storage\StorageInterface;

class MediaNormalizer implements NormalizerInterface
{


    private const ALREADY_CALLED = 'MEDIA_NORMALIZER_ALREADY_CALLED';


    public function __construct(
        #[Autowire(service: 'api_platform.jsonld.normalizer.item')]
        private readonly NormalizerInterface $normalizer,
        private readonly StorageInterface    $storage
    ) {

    }


    /**
     * @inheritDoc
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $context[self::ALREADY_CALLED] = true;

        $object->fileUrl = $this->storage->resolveUri($object, 'file');

        return $this->normalizer->normalize($object, $format, $context);
    }


    /**
     * @inheritDoc
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof Media;
    }


    /**
     * @inheritDoc
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            Media::class => true,
        ];
    }


}