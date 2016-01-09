<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Block;

class BlockHydratorFactory
{
    public function __invoke($services)
    {
        return new BlockHydrator(
            $services->get('Application\Database\User\UserModel')
        );
    }
}
