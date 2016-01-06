<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Mod;

use Application\Hydrator\Hydrator;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class ModHydrator extends Hydrator
{
    protected $userModel;
    protected $chatModel;

    public function __construct(UserModel $userModel, ChatModel $chatModel)
    {
        $this->userModel = $userModel;
        $this->chatModel = $chatModel;
    }

    public function buildEntity($mod)
    {
        $user = $this->userModel->fetch($mod->user_id);
        $chat = $this->chatModel->fetch($mod->chat_id);

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
            $mod->user = $userEntity;
            unset($mod->user_id);
        }

        if ($this->getParam('embedChat')) {
            $userEntity = new Entity($chat, $chat->id);
            $chatEntity->getLinks()->add(Link::factory(array(
                'rel' => 'self',
                'route' => array(
                    'name' => 'chat.rest.chat',
                    'params' => array(
                        'chat_id' => $chat->id,
                    ),
                ),
            )));
            $mod->chat = $chatEntity;
            unset($mod->chat_id);
        }

        $modEntity = new Entity($this->extract($mod));

        // ToDo: define a self link attached to, with parameter, either:
        //       - for "linkSelfUser", the user API /users/:id/mods
        //       - for "linkSelfChat", the chat API /chat/:id/mods
        // $modEntity->getLinks()->add(Link::factory(array(
        //     'rel' => 'self',
        //     'route' => array(
        //         'name' => 'mod.rest.mod',
        //         'params' => array(
        //             'mod_id' => $mod->id,
        //         ),
        //     ),
        // )));

        if ($this->getParam('linkUser')) {
            $modEntity->getLinks()->add(Link::factory(array(
                'rel' => 'user',
                'route' => array(
                    'name' => 'user.rest.user',
                    'params' => array(
                        'user_id' => $user->id,
                    ),
                ),
            )));
            unset($mod->user_id);
        }

        if ($this->getParam('linkChat')) {
            $modEntity->getLinks()->add(Link::factory(array(
                'rel' => 'chat',
                'route' => array(
                    'name' => 'chat.rest.chat',
                    'params' => array(
                        'chat_id' => $chat->id,
                    ),
                ),
            )));
            unset($mod->chat_id);
        }

        return $modEntity;
    }
}
