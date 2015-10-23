<?php
namespace Application\Database\Chat;

class ChatModelFactory
{
    public function __invoke($services)
    {
        return new ChatModel(
            $services->get('Application\Database\Chat\ChatTableGateway')
        );
    }
}
