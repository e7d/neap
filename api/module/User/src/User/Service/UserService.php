<?php
namespace User\Service;

use Application\Database\User\User;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class UserService
{
    protected $hydrator;
    protected $userModel;

    public function __construct($hydrator, $userModel)
    {
        $this->hydrator = $hydrator;
        $this->userModel = $userModel;
    }

    public function fetchAll($params, $paginated = true)
    {
        if ($paginated) {
            $select = new Select('user');

            $this->hydrator->setParam("isCollection", true);
            $hydratingResultSet = new HydratingResultSet(
                $this->hydrator,
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

        return $this->hydrator->buildEntity($user);
    }

    public function fetchByChannel($channelId)
    {
        // ToDo
    }
}
