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

/**
 * Panel
 */
class Panel extends ObjectProperty
{
    /** @var string */
    public $panel_id;

    /** @var string */
    public $channel_id;

    /** @var string */
    public $title;

    /** @var string */
    public $position;

    /** @var string */
    public $banner;

    /** @var string */
    public $banner_link;

    /** @var string */
    public $description;

    /** @var string */
    public $created_at;

    /** @var string */
    public $updated_at;

    /**
     * @param array $data
     *
     * @return void
     */
    public function exchangeArray(array $data)
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
