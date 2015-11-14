<?php
namespace User\V1\Rest\MyUser;

class MyUserResourceFactory
{
    public function __invoke($services)
    {
        return new MyUserResource();
    }
}
