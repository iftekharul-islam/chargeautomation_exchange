<?php


namespace Core\System\ResponseInstance\Hotel;


use Core\System\ResponseInstance\SetClassAttribute;

class Room
{
    use SetClassAttribute;

    /**
     * @var string|null
     */
    public $Id;

    /**
     * @var string|null
     */
    public $Name;
    /**
     * @var string|null
     */
    public $InternalName;
    /**
     * @var string|null
     */
    public $ExternalId;

    /**
     * Room constructor.
     * @param array $data
     */
    public function __construct($data=[])
    {
        $data = is_string($data) ? json_decode($data, true) : $data;
        $this->setAttributes($data);
    }
}