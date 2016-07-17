<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Block;
use Zend\ServiceManager\ServiceManager;

/**
 * BlockModelFactory
 */
class BlockModelFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return BlockModel
     */
    public function __invoke(ServiceManager $serviceManager)
    {
        return new BlockModel(
            $serviceManager->get('Application\Database\Block\BlockTableGateway')
        );
    }
}
