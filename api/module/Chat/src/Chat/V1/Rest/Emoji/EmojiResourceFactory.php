<?php
namespace Chat\V1\Rest\Emoji;

class EmojiResourceFactory
{
    public function __invoke($services)
    {
        return new EmojiResource();
    }
}
