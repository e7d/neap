<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Chat\V1\Service;

use Application\Database\Chat\Chat;
use Application\Database\Follow\Follow;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ChatService
{
    protected $chatModel;
    protected $chatHydrator;

    public function __construct($chatModel, $chatHydrator)
    {
        $this->chatModel = $chatModel;
        $this->chatHydrator = $chatHydrator;
    }

    public function fetch($id)
    {
        $chat = $this->chatModel->fetch($id);
        if (!$chat) {
            return null;
        }

        $this->chatHydrator->setParam('linkChannel');
        $this->chatHydrator->setParam('linkUser');

        return $this->chatHydrator->buildEntity($chat);
    }

    public function fetchByChannel($channelId)
    {
        $chat = $this->chatModel->fetchByChannel($channelId);
        if (!$chat) {
            return null;
        }

        $this->chatHydrator->setParam('embedChannel');

        return $this->chatHydrator->buildEntity($chat);
    }
}
