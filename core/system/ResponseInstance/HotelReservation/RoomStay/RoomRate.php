<?php


namespace Core\System\ResponseInstance\HotelReservation\RoomStay;


use Core\System\ResponseInstance\SetClassAttribute;

class RoomRate
{
    use SetClassAttribute;


    /**
     * @var string|null
     */
    public $EffectiveDate, $ExpireDate;

    /**
     * @var float
     */
    public $UnitMultiplier = 1;

    /**
     * @var array
     */
    public array $Base = [
        'AmountAfterTax' => 0.00,
        'AmountBeforeTax' => 0.00,
        'CurrencyCode' => null,
        'Taxes' => [
            [
                "Code" => "",
                "Amount" => "0",
                "CurrencyCode" => null,
                "Percent" => 0.00,
            ]
        ]
    ];

    public array $Total = [
        'AmountAfterTax' => 0.00,
        'AmountBeforeTax' => 0.00,
        'CurrencyCode' => null,
        'Taxes' => [
            [
                "Code" => "",
                "Amount" => "0",
                "CurrencyCode" => null,
                "Percent" => 0.00,
            ]
        ]
    ];

    /**
     * @param $data
     */
    public function __construct($data)
    {

        $this->setAttributes($data);
    }
}