<?php
namespace User\Service;

use User\Model\User;
use Zend\Db\TableGateway\TableGateway;

class UserService
{
    protected $userTableGateway;

    public function __construct(TableGateway $userTableGateway)
    {
        $this->userTableGateway = $userTableGateway;
    }

    public function fetchAll($params)
    {
        $resultSet = $this->userTableGateway->select();
        return $resultSet;
    }

    public function fetch($id)
    {
        $rowset = $this->userTableGateway->select(array('user_id' => $id));
        $user = $rowset->current();
        if (!$user) {
            throw new \Exception("Could not find row $id");
        }
        return $user;
    }

    // public function saveUser(User $user)
    // {
    //     $data = array(
    //         'username' => $user->username,
    //     );
    //
    //     $id = (int) $user->id;
    //     if ($id == 0) {
    //         $this->userTableGateway->insert($data);
    //     } else {
    //         if ($this->getUser($id)) {
    //             $this->userTableGateway->update($data, array('id' => $id));
    //         } else {
    //             throw new \Exception('User id does not exist');
    //         }
    //     }
    // }
    //
    // public function deleteUser($id)
    // {
    //     $this->userTableGateway->delete(array('id' => (int) $id));
    // }
}
