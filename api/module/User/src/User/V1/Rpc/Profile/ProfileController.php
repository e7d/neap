<?php
namespace User\V1\Rpc\Profile;

use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use ZF\ApiProblem\ApiProblem;
use ZF\Hal\View\HalJsonModel;

class ProfileController extends AbstractActionController
{
    public function profileAction()
    {
        $request = $this->getRequest();
        if (!($request instanceof Request))
        {
            return;
        }

        $method = $request->getMethod();

        switch ($method) {
            case 'GET':
                $serviceManager = $this->getServiceLocator();

                $identityService = $serviceManager->get('Application\Authorization\IdentityService');
                $user = $identityService->getIdentity();

                return new HalJsonModel(get_object_vars($user));
                break;

            case 'DELETE':
                $container = new Container('oauth');
                $container->getManager()->getStorage()->clear();

                $response = $this->getResponse();
                if (!($response instanceof Response))
                {
                    return;
                }
                $response->setStatusCode(204)->setContent(null);
                break;

            default:
                return new ApiProblem(405, 'The '.$method.' method has not been defined');
        }
    }
}
