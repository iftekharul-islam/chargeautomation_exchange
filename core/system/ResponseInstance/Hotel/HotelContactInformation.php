<?php


namespace Core\System\ResponseInstance\Hotel;


use Core\System\ResponseInstance\SetClassAttribute;

class HotelContactInformation
{
    use SetClassAttribute;

    public $Address = [
        'AddressLine' => null,
        'CityName' => null,
        'CountryCode' => null,
        'ZipCode' => null
    ];

    public $ContactEmail;
    public $ContactPhones = array(['Type' => 'PHONE', 'Number' => null]);

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->setAttributes($data);
    }

}