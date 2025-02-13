<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class HeaderFooter extends Entity
{
    protected $_accessible = [
        'type' => true,
        'heading' => true,
        'description' => true,
        'background_image' => true, // File upload
        'status' => true,
        'created_at' => true,
        'updated_at' => true
    ];
}
