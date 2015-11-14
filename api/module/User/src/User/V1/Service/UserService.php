<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace User\V1\Service;

use Application\Database\User\User;
use User\V1\Rest\Block\BlockCollection;
use User\V1\Rest\User\UserCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class UserService
{
    protected $userModel;
    protected $userHydrator;

    public function __construct($userModel, $userHydrator)
    {
        $this->userModel = $userModel;
        $this->userHydrator = $userHydrator;
    }

    public function fetchAll($params)
    {
        $select = new Select('user');

        $this->userHydrator->setParam('linkChannel');

        $hydratingResultSet = new HydratingResultSet(
            $this->userHydrator,
            new User()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->userModel->tableGateway->getAdapter(),
            $hydratingResultSet
        );

        $collection = new UserCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
        $user = $this->userModel->fetch($id);
        if (!$user) {
            return null;
        }

        $this->userHydrator->setParam('embedChannel');
        $this->userHydrator->setParam('linkBlock');
        $this->userHydrator->setParam('linkFavorite');
        $this->userHydrator->setParam('linkFollow');
        $this->userHydrator->setParam('linkMod');

        return $this->userHydrator->buildEntity($user);
    }

    public function fetchByChannel($channelId)
    {
        $user = $this->userModel->fetchByChannel($channelId);
        if (!$user) {
            return null;
        }

        $this->userHydrator->setParam('embedChannel');

        return $this->userHydrator->buildEntity($user);
    }

    public function fetchBlockedUsers($params)
    {
        $where = new Where();
        $where->equalTo('block.user_id', $params['user_id']);

        $select = new Select('user');
        $select->join('block', 'block.blocked_user_id = user.user_id', array(), 'inner');
        $select->where($where);

        $hydratingResultSet = new HydratingResultSet(
            $this->userHydrator,
            new User()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->userModel->tableGateway->getAdapter(),
            $hydratingResultSet
        );

        $collection = new BlockCollection($paginatorAdapter);
        return $collection;
    }
}
