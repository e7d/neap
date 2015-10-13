<?php
/**
 * @license   xxx
 * @copyright xxx
 */

namespace Application\Database;

class DatabaseServiceFactory
{
    public function __invoke($services)
    {
        return new DatabaseService(
            $services->get('Config')['db']['adapters']['media-streaming']
        );
    }
}
