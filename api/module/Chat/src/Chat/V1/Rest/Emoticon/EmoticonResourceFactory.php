<?php
namespace Chat\V1\Rest\Emoticon;

class EmoticonResourceFactory
{
    public function __invoke($services)
    {
        return new EmoticonResource();
    }
}
