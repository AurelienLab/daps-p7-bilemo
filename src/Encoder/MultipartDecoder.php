<?php

namespace App\Encoder;

use ApiPlatform\State\SerializerContextBuilderInterface;
use ApiPlatform\State\Util\RequestAttributesExtractor;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class MultipartDecoder implements DecoderInterface
{


    public const FORMAT = 'multipart';


    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
    }


    /**
     * @inheritDoc
     */
    public function decode(string $data, string $format, array $context = []): ?array
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            return null;
        }

        $data = array_map(
            function (string $element) {
                $decoded = json_decode($element, true);
                return is_array($decoded) ? $decoded : $element;
            },
            $request->request->all()
        );

        $files = $request->files->all();

        return array_merge($data, $files);
    }


    /**
     * @inheritDoc
     */
    public function supportsDecoding(string $format): bool
    {
        return self::FORMAT === $format;
    }


}