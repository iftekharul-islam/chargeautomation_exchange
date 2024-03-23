<?php


namespace Core\System\ResponseInstance\HotelReservation\RoomStay;


use Core\System\ResponseInstance\ResponseInstance;
use Core\System\ResponseInstance\SetClassAttribute;

class RoomStay implements ResponseInstance
{
    use SetClassAttribute {
        getAttributeValue as protected getAttributeValueFromTrait;
    }

    /**
     * @var string|null
     */
    public $SourceOfBusiness;

    /**
     * @var RoomType
     */
    public RoomType $RoomType;

    /**
     * @var RatePlan
     */
    public RatePlan $RatePlan;

    /**
     * @var RoomRate []
     */
    public array $RoomRates = [];

    /**
     * Split or full Amount collection values with due_date
     * @var array
     */
    public array $DepositPayments = []; //array(['Percent' => 0.00, 'CurrencyCode' => null, 'Amount' => 0, 'Deadline' => null]);
    public array $Comments = [];//array(['GuestViewable' => false, 'Comment' => null]);

    public array $GuestCounts = [];//array(["AgeQualifyingCode" => null, "Count" => 0]);


    /**
     * @var array
     */
    public array $Total = [
        'AmountAfterTax' => 0,
        'AmountBeforeTax' => 0,
        'CurrencyCode' => null,
        'AmountPaid' => null,
        'Taxes' => [
           /* [
                'Code' => null,
                'Amount' => 0,
                'CurrencyCode' => null,
                'Percent' => '0.00'
            ]*/
        ]
    ];


    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->__initiateInstanceAttributes();
        $this->setAttributes($data);
    }


    function __initiateInstanceAttributes()
    {
        $this->RoomType = new RoomType([]);
        $this->RatePlan = new RatePlan([]);
    }



    private function getAttributeValue($attribute_name, $data)
    {
        if ($attribute_name == 'RoomRates' && is_array($data[$attribute_name])) {
            $rates = [];
            foreach ($data[$attribute_name] as $key => $rate) {
                $rates[$key] = new RoomRate($rate);
            }

            return $rates;

        } else {
            return $this->getAttributeValueFromTrait($attribute_name, $data);
        }
    }
}