<?php


namespace Core\System\ResponseInstance\HotelReservation\RoomStay;


use Core\System\ResponseInstance\SetClassAttribute;

class RoomType
{
    use SetClassAttribute;

    /**
     * @var null| string
     */
    public $RoomID;
    /**
     * @var null| string
     */
    public $Name;
    /**
     * @var null| string
     */
    public $RoomTypeCode;

    /**
     * @var null| string
     */
    public $RoomDescription;

    /**
     * @var null| string
     */
    public $RoomShortDescription;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->setAttributes($data);
    }
}