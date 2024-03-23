<?php

/**
 * @param $data
 * @param $value_to_map
 * @return void
 */
function set_property_contact_information(&$data, $value_to_map)
{
    if (!empty($value_to_map)) {
        $data['HotelContactInformation'] = [
            'Address' => [
                'AddressLine' => $value_to_map['street'] . ' ' . $value_to_map['number'],
                'CityName' => $value_to_map['city'],
                'CountryCode' => $value_to_map['postcode']
            ]
        ];
    }
}

/**
 * @param $data
 * @param $value_to_map
 */
function set_guest_phones(&$data, $value_to_map)
{
    if (!empty($value_to_map)) {
        $data['Profiles'][0]['Telephone'][] = ['PhoneNumber' => $value_to_map, 'PhoneTechType' => 'PHONE'];
    }
}


/**
 * This will set Guests Count with Age qualifiers array to Reservation key mapper data
 * provisioned us through OwnerRez PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_reservation_adult_counts(&$data, $value_to_map)
{

    /** Reflect data  for a Single Reservation Comment */
    if (!empty($value_to_map)) {
        $data['RoomStay']['GuestCounts'][] = [
            'AgeQualifyingCode' => 'adults',
            'Count' => $value_to_map
        ];
    }
}

/**
 * This will set reservation comments array to Reservation key mapper data
 * provisioned us through OwnerRez PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_reservation_comments(&$data, $value_to_map)
{
    /** Reflect data  for a Single Reservation Comment */
    if (!empty($value_to_map)) {

        $data['RoomStay']['Comments'] = array(
            [
                'GuestViewable' => false,
                'Comment' => $value_to_map
            ]
        );

    }
}

/**
 * This will set room rates array to Reservation key mapper data
 * provisioned us through Opera PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_reservation_price(&$data, $value_to_map)
{
    $data['RoomStay']['Total']['AmountAfterTax'] = $data['RoomStay']['Total']['AmountBeforeTax'] = 0;

    foreach ($value_to_map as $key => $amount) {
        $data['RoomStay']['Total']['AmountAfterTax'] =
        $data['RoomStay']['Total']['AmountBeforeTax'] += $amount;
    }

}

?>