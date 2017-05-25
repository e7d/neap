<?php
/**
 * Neap (http://neap.io/)
 *
 * @package   Neap
 * @author    Michaël "e7d" Ferrand <michael@e7d.io>
 * @copyright 2017 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 * @link      https://github.com/e7d/neap
 *
 * PHP version 7.1
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
