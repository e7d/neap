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
        $this->id = (!empty($data['team_id'])) ? $data['team_id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->display_name = (!empty($data['display_name'])) ? $data['display_name'] : null;
        $this->logo = (!empty($data['logo'])) ? $data['logo'] : null;
        $this->banner = (!empty($data['banner'])) ? $data['banner'] : null;
        $this->background = (!empty($data['background'])) ? $data['background'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at'] : null;
    }
}
