<?php
namespace User\V1\Rpc\Profile;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use ZF\ApiProblem\ApiProblem;
use ZF\ContentNegotiation\ViewModel;

class ProfileController extends AbstractActionController
{
    public function profileAction()
    {
        $method = $this->getRequest()->getMethod();

        switch ($method) {
            case 'GET':
                $profile = $this->getServiceLocator()
                    ->get('Application\Authorization\IdentityService')
                    ->getIdentity();

                $user = $this->getServiceLocator()
                    ->get('Application\Database\User\UserModel')
                    ->fetch($profile->id);

                return new ViewModel((array) $user);
                break;

            case 'DELETE':
                $container = new Container('oauth');
                $container->getManager()->getStorage()->clear();

                $this->getResponse()->setStatusCode(204)->setContent(null);
                break;

            default:
                return new ApiProblem(405, 'The '.$method.' method has not been defined');
        }
    }
}
