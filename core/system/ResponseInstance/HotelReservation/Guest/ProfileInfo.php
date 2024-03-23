<?php


namespace Core\System\ResponseInstance\HotelReservation\Guest;


use Core\System\ResponseInstance\SetClassAttribute;

class ProfileInfo
{
    use SetClassAttribute;

    public $UniqueID;
    public $ProfileType;

    /**
     * @var bool|null
     */
    public  $ShareAllOptOutInd, $ShareAllMarketInd, $VIP_Indicator;

    /**
    * @var null| string
    */
    public $AddressLine;
    /**
     * @var null| string
     */
    public $CityName;
    /**
     * @var null| string
     */
    public $PostalCode;
    /**
     * @var null| string
     */
    public $CountryName;
    /**
     * @var null| string
     */
    public $NamePrefix;
    /**
     * @var null| string
     */
    public $GivenName;
    /**
     * @var null| string
     */
    public $Surname;

    public array $Emails = [];
    public array $Telephone = [];//array(['PhoneNumber' => null, 'PhoneTechType' => null]);

    /**
     * @param $data
     */
    public function __construct($data)
    {

        $this->setAttributes($data);
    }

}