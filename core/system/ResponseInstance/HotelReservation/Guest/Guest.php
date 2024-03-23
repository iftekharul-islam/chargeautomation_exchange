<?php


namespace Core\System\ResponseInstance\HotelReservation\Guest;


use Core\System\ResponseInstance\SetClassAttribute;

class Guest
{

    use SetClassAttribute {
        getAttributeValue as protected getAttributeValueFromTrait;
    }

    /**
     * @var null| string
     */
    public $AgeQualifyingCode;
    public bool $PrimaryIndicator = true;

    /**
     * @var ProfileInfo []
     */
    public array $Profiles = [];


    private function getAttributeValue($attribute_name, $data)
    {
        if ($attribute_name == 'Profiles' && is_array($data[$attribute_name])) {
            $Profiles = [];
            foreach ($data[$attribute_name] as $key => $profile) {
                $Profiles[$key] = new ProfileInfo($profile);
            }

            return $Profiles;

        } else {
            return $this->getAttributeValueFromTrait($attribute_name, $data);
        }
    }

    public function __construct($data)
    {
        $this->setAttributes($data);
    }

}