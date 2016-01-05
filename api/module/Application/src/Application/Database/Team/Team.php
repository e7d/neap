<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\Team;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Team extends ObjectProperty
{
    public $id;
    public $name;
    public $display_name;
    public $logo;
    public $banner;
    public $background;
    public $created_at;
    public $updated_at;

    public function exchangeArray($data)
    {
        $this->id = $data['team_id'];
        $this->name = $data['name'];
        $this->display_name = $data['display_name'];
        $this->logo = $data['logo'];
        $this->banner = $data['banner'];
        $this->background = $data['background'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }
}
