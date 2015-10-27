<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\Block;

use Application\Database\Hydrator;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class BlockHydrator extends Hydrator
{
    protected $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function buildEntity($block)
    {
        $user = $this->userModel->fetch($block->user_id);
        $blockedUser = $this->userModel->fetch($block->blocked_user_id);

        if ($this->getParam('embedUser')) {
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
            $block->user = $userEntity;
            unset($block->user_id);
        }

        if ($this->getParam('embedBlockedUser')) {
            $blockedUserEntity = new Entity($blockedUser, $blockedUser->id);
            $blockedUserEntity->getLinks()->add(Link::factory(array(
                'rel' => 'self',
                'route' => array(
                    'name' => 'user.rest.user',
                    'params' => array(
                        'user_id' => $blockedUser->id,
                    ),
                ),
            )));
            $block->blocked_user = $blockedUserEntity;
            unset($block->blocked_user_id);
        }

        $blockEntity = new Entity($this->extract($block));

        // ToDo: define a self link attached to the user API /api/users/:id/blocks
        // $blockEntity->getLinks()->add(Link::factory(array(
        //     'rel' => 'self',
        //     'route' => array(
        //         'name' => 'block.rest.block',
        //         'params' => array(
        //             'block_id' => $block->id,
        //         ),
        //     ),
        // )));

        if ($this->getParam('linkUser')) {
            $blockEntity->getLinks()->add(Link::factory(array(
                'rel' => 'user',
                'route' => array(
                    'name' => 'user.rest.user',
                    'params' => array(
                        'user_id' => $user->id,
                    ),
                ),
            )));
            unset($block->user_id);
        }

        if ($this->getParam('linkBlockedUser')) {
            $blockEntity->getLinks()->add(Link::factory(array(
                'rel' => 'blocked_user',
                'route' => array(
                    'name' => 'user.rest.user',
                    'params' => array(
                        'user_id' => $blockedUser->id,
                    ),
                ),
            )));
            unset($block->blocked_user_id);
        }

        return $blockEntity;
    }
}
