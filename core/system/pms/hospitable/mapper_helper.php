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
                'CountryCode' => $value_to_map['country'],
                'CountryName' => $value_to_map['country_name'],
                'StateCode' => $value_to_map['state'],
                'CityName' => $value_to_map['city'],
                'ZipCode' => $value_to_map['postcode'],
                'AddressLine' => $value_to_map['street'],
            ]
        ];
    }
}

/**
 * @param $data
 * @param $value_to_map
 */
function set_guest_phones(&$data, $value_to_map) {

    if(is_array($value_to_map)) {
        foreach ($value_to_map as $phone) {
            $data['ResGuest']['Profiles'][0]['Telephone'][] = ['PhoneNumber' => $phone['number'], 'PhoneTechType' => 'PHONE'];
        }

    } else {
        $data['ResGuest']['Profiles'][0]['Telephone'][] = ['PhoneNumber' => $value_to_map, 'PhoneTechType' => 'PHONE'];
    }
}

/**
 * This will set Guests Count with Age qualifiers array to Reservation key mapper data
 * provisioned us through Opera PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_reservation_guest_counts(&$data, $value_to_map)
{
    /** Reflect data  for a Single Reservation Comment */
    if (is_array($value_to_map)) {

        foreach ($value_to_map as $AgeQualifyingCode => $value) {
            $data['RoomStay']['GuestCounts'][] =
                [
                    'AgeQualifyingCode' => $AgeQualifyingCode,
                    'Count' => $value
                ];
        }
    }
}

function set_reservation_amount_after_and_before_tax(&$data, $value_to_map)
{
    $data['RoomStay']['Total']['AmountBeforeTax'] = $data['RoomStay']['Total']['AmountAfterTax'] = $value_to_map;
}

function set_reservation_total_amount(&$data, $value_to_map)
{
    if (!empty($value_to_map)) {
        $data['RoomStay']['Total']['AmountAfterTax'] =($value_to_map)/100;
    }
}

?>