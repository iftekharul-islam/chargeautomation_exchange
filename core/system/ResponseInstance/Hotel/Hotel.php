<?php
namespace Core\System\ResponseInstance\Hotel;

use Core\System\ResponseInstance\ResponseInstance;
use Core\System\ResponseInstance\SetClassAttribute;

class Hotel implements ResponseInstance
{
    use SetClassAttribute;

    /**
     * @var array
     */
    public array $HotelInformation = [
        'Name' => '',
        'NickName' => '',
        'ChainCode' => null,
        'HotelCode' => null,
        'TimeZone' => null,
        'CheckIn' => null,
        'CheckOut' => null,
        'Currency' => null,
        "MasterCalendar" => null,
        "NetworkActive" => null
    ];


    /**
     * @var HotelContactInformation
     */
    public HotelContactInformation $HotelContactInformation;
    /*= [
        'Address' => [
            'AddressLine' => null,
            'CityName' => null,
            'CountryCode' => null,
            'ZipCode' => null,
            'Lat'=>null,
            'Lng'=>null,

        ],

        'ContactEmail' => null,
        'ContactPhones' => [
            [
                'Type' => 'PHONE',
                'Number' => null
            ]
        ],
    ];*/

    /**
     * @var FacilityInfo
     */
    public FacilityInfo $FacilityInfo;

    /**
     * @var array
     */
    public array $ResGlobal = [];


    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->__initiateInstanceAttributes();
        $this->setAttributes($data);
        $this->setResGlobal();
    }

    private function setResGlobal(): void
    {
        $this->ResGlobal = [
            'HotelInformation' => $this->HotelInformation,
            'HotelContactInformation' => $this->HotelContactInformation,
            'HotelExtendedInformation' => $this->FacilityInfo,
        ];
    }


    function __initiateInstanceAttributes()
    {
        $this->FacilityInfo = new FacilityInfo([]);
        $this->HotelContactInformation = new HotelContactInformation([]);
    }
}


