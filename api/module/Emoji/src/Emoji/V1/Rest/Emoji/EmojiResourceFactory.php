<?php
namespace Emoji\V1\Rest\Emoji;

class EmojiResourceFactory
{
    public function __invoke($serviceManager)
    {
        return new EmojiResource();
    }
}
