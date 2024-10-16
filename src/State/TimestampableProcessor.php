<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Put;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TimestampableInterface;

class TimestampableProcessor implements ProcessorInterface
{


    public function __construct(
        private ProcessorInterface $processor
    ) {

    }


    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        // Apply this processor only for PUT operations
        if (!($operation instanceof Put)) {
            // Delegate the processing to the default processor
            return $this->processor->process($data, $operation, $uriVariables, $context);
        }

        // If the entity implements TimestampableInterface and already exists
        if ($data instanceof TimestampableInterface) {
            // Retrieve the existing entity
            if ($context['previous_data']) {
                // Keep the original createdAt value
                $data->setCreatedAt($context['previous_data']->getCreatedAt());
            }

            $data->setUpdatedAt(new \DateTimeImmutable());
        }

        // Continue with the default processor logic
        return $this->processor->process($data, $operation, $uriVariables, $context);
    }


}