<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

class EntitySchema {
    
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function getEntitySchema(string $entityClass): array
    {
        $entityClass = 'App\\Entity\\' . ucfirst($entityClass);
        $metadata = $this->entityManager->getClassMetadata($entityClass);
        $fields = $this->getFieldsMetadata($metadata);
        $associations = $this->getAssociationsMetadata($metadata);
        return array_merge($fields, $associations);
    }

    private function getFieldsMetadata(ClassMetadata $metadata): array
    {
        $fields = [];
        foreach ($metadata->fieldMappings as $fieldName => $fieldMapping) {
            $fields[$fieldName] = [
                'type' => $fieldMapping['type'],
                'nullable' => $fieldMapping['nullable'] ?? false,
            ];
        }
        return $fields;
    }

    private function getAssociationsMetadata(ClassMetadata $metadata): array
    {
        $associations = [];
        foreach ($metadata->associationMappings as $fieldName => $associationMapping) {
            $targetEntity = $associationMapping['targetEntity'];
            $entityName = substr($targetEntity, strrpos($targetEntity, '\\') + 1);

            $associations[$fieldName] = [
                'type' => $this->getAssociationType($associationMapping['type']),
                'nullable' => $this->isAssociationNullable($metadata, $fieldName),
                'entity' => $entityName ,
            ];
        }
        return $associations;
    }

    private function isAssociationNullable(ClassMetadata $metadata, string $fieldName): bool
    {
        // Pour les associations ManyToOne et OneToOne
        if (isset($metadata->fieldMappings[$fieldName])) {
            return $metadata->fieldMappings[$fieldName]['nullable'] ?? false;
        }

        // Pour les associations OneToMany et ManyToMany
        // Ces associations sont généralement considérées comme nullable
        // car elles peuvent être des collections vides
        return true;
    }

    private function getAssociationType(int $type): string
    {
        switch ($type) {
            case ClassMetadata::ONE_TO_ONE:
                return 'OneToOne';
            case ClassMetadata::MANY_TO_ONE:
                return 'ManyToOne';
            case ClassMetadata::ONE_TO_MANY:
                return 'OneToMany';
            case ClassMetadata::MANY_TO_MANY:
                return 'ManyToMany';
            default:
                return 'Unknown';
        }
    }

}
