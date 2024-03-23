<?php


namespace Core\System\ResponseInstance\HotelReservation\RoomStay;


use Core\System\ResponseInstance\SetClassAttribute;

class RatePlan
{
    use SetClassAttribute;

    /**
     * @var string
     */
    public  $EffectiveDate;

    /**
     * @var string|null
     */
    public $ExpireDate;

    /**
     * @var string|null
     */
    public $RatePlanCode;
    /**
     * @var string|null
     */
    public $RatePlanName;
    /**
     * @var string|null
     */
    public $RatePlanDescription;

    /**
     * KeyValue  pair. e.g DepositPolicy, TaxInformation, CancelPolicy
     * @var array
     */
    //public array $AdditionalDetailDescription = [];

    /**
     * @param $data
     */
    public function __construct($data)
    {

        $this->setAttributes($data);
    }


}