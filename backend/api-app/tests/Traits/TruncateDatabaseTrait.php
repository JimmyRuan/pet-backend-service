<?php

namespace App\Tests\Traits;

use Doctrine\ORM\EntityManagerInterface;

trait TruncateDatabaseTrait
{
    /**
     * Truncates all database entities.
     */
    private function truncateEntities(EntityManagerInterface $entityManager): void
    {
        $connection = $entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($entityManager->getMetadataFactory()->getAllMetadata() as $metadata) {
            $tableName = $metadata->getTableName();
            $connection->executeStatement($platform->getTruncateTableSQL($tableName, true));
        }
        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=1');
    }
}
