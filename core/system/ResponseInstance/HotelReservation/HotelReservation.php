<?php


namespace Core\System\ResponseInstance\HotelReservation;


use Core\System\ResponseInstance\HotelReservation\Guest\Guest;
use Core\System\ResponseInstance\HotelReservation\RoomStay\RoomStay;
use Core\System\ResponseInstance\SetClassAttribute;

/**
 * Class HotelReservation
 * @property mixed|null pms_user_id
 * @property array|string|null webhook_entity_type
 * @package Core\System\ResponseInstance\HotelReservation
 */
class HotelReservation
{

    use SetClassAttribute;

    public $ID;
    public $ResStatus;
    public $ResCode;
    public $CreateDateTime;
    public $LastModifyDateTime;
    public $BookingChannel;
    public array $TimeSpan = ['Start' => null, "End" => null];

    public array $BasicPropertyInfo = ['HotelCode' => null, 'HotelName' => '', 'ParentHotelCode'=>null];

    /**
     * @var RoomStay
     */
    public RoomStay $RoomStay;

    /**
     * @var Guest
     */
    public Guest $ResGuest;

    /**
     * @var array
     */
    public array $ResGlobal = [];


    /**
     * HotelReservation constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $data = is_string($data) ? json_decode($data, true) : $data;

        $this->__initiateInstanceAttributes();
        $this->setAttributes($data);
        $this->setResGlobal();
    }

    function __initiateInstanceAttributes()
    {
        $this->RoomStay = new RoomStay([]);
        $this->ResGuest = new Guest([]);
    }


    private function setResGlobal()
    {

        $this->ResGlobal = [
            'GuestCounts' => $this->RoomStay->GuestCounts,
            'TimeSpan' => $this->TimeSpan,
            'Comments' => $this->RoomStay->Comments,
            'DepositPayments' => $this->RoomStay->DepositPayments,
            'Total' => $this->RoomStay->Total,
            'HotelReservationIDs' => [],
            'Profiles' => $this->ResGuest->Profiles,
            'BasicPropertyInfo' => $this->BasicPropertyInfo
        ];
    }


}