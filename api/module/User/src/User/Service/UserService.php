<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace User\Service;

use Application\Database\User\User;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
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

    public function fetchAll($params, $paginated = true)
    {
        if ($paginated) {
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

            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }

        $resultSet = $this->userModel->tableGateway->select();
        return $resultSet;
    }

    public function fetch($id)
    {
        $user = $this->userModel->fetch($id);
        if (!$user) {
            return null;
        }

        $this->userHydrator->setParam('embedChannel');

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
}
