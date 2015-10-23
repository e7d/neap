<?php
namespace Application\Database\Panel;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Panel extends ObjectProperty
{
    public $id;
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
        $this->id = (!empty($data['panel_id'])) ? $data['panel_id'] : null;
        $this->channel_id = (!empty($data['channel_id'])) ? $data['channel_id'] : null;
        $this->title = (!empty($data['title'])) ? $data['title'] : null;
        $this->position = (!empty($data['position'])) ? $data['position'] : null;
        $this->banner = (!empty($data['banner'])) ? $data['banner'] : null;
        $this->description = (!empty($data['description'])) ? $data['description'] : null;
        $this->banner_link = (!empty($data['banner_link'])) ? $data['banner_link'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at'] : null;
    }
}
