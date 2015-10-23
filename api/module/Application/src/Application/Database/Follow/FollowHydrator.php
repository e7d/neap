<?php
namespace Application\Database\Follow;

use Application\Database\Follow\Follow;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class FollowHydrator implements HydratorInterface
{
    protected $params;
    protected $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->params = array();
        $this->userModel = $userModel;
    }

    public function hydrate(array $data, $follow)
    {
        $follow->exchangeArray($data);
        $followEntity = $this->buildEntity($follow);
        return $followEntity;
    }

    public function extract($object)
    {
        return get_object_vars($object);
    }

    public function setParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function buildEntity($follow)
    {
        $user = $this->userModel->fetch($follow->user_id);

        $userEntity = new Entity($user, $user->id);
        $userEntity->getLinks()->add(Link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'user.rest.user',
                'params' => array(
                    'user_id' => $user->id,
                ),
            ),
        )));
        $follow->user = $userEntity;
        unset($follow->user_id);

        $followEntity = new Entity($this->extract($follow));

        $followEntity->getLinks()->add(Link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'channel.rest.follows',
                'params' => array(
                    'channel_id' => $follow->channel_id,
                    'follow_id' => 'hehe',
                ),
            ),
        )));

        // $followEntity->getLinks()->add(Link::factory(array(
        //     'rel' => 'user',
        //     'route' => array(
        //         'name' => 'user.rest.user',
        //         'params' => array(
        //             'user_id' => $user->id,
        //         ),
        //     ),
        // )));
        // unset($follow->user_id);

        return $followEntity;
    }
}
