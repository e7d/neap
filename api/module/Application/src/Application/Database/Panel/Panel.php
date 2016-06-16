<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Panel;

use Zend\Hydrator\ObjectProperty;

class Panel extends ObjectProperty
{
    public $panel_id;
    public $channel_id;
    public $title;
    public $position;
    public $banner;
    public $banner_link;
    public $description;
    public $created_at;
    public $updated_at;

    public function exchangeArray($data)
    {
        $this->panel_id = $data['panel_id'];
        $this->channel_id = $data['channel_id'];
        $this->title = $data['title'];
        $this->position = $data['position'];
        $this->banner = $data['banner'];
        $this->description = $data['description'];
        $this->banner_link = $data['banner_link'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }
}
