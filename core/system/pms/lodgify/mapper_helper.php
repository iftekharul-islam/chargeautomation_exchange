<?php

/**
 * @param $data
 * @param $value_to_map
 * @return void
 */
function set_property_units_information(&$data, $value_to_map): void
{

    if (isset($value_to_map['rooms']) && count($value_to_map['rooms']) > 0) {

        $data['FacilityInfo']['HotelUnits']['TotalUnits'] = count($value_to_map['rooms']);

        foreach ($value_to_map['rooms'] as $key => $guest_room) {

            $data['FacilityInfo']['HotelUnits']['HotelUnit'][$key] = [
                'Id' => $guest_room['id'],
                'Name' => $guest_room['name']
            ];

        }

    }
}

/**
 * @param $data
 * @param $value_to_map
 * @return void
 */
function set_reservation_adult_counts(&$data, $value_to_map): void
{
    if (!is_null($value_to_map)) {
        $data['RoomStay']['GuestCounts'][] = [
            'AgeQualifyingCode' => 'adults',
            'Count' => $value_to_map
        ];
    }
}

/**
 * @param $data
 * @param $value_to_map
 * @return void
 */
function set_reservation_comments(&$data, $value_to_map): void
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
 * @param $data
 * @param $value_to_map
 * @return void
 */
function set_guest_phones(&$data, $value_to_map): void
{
    if (!empty($value_to_map)) {
        $data['ResGuest']['Profiles'][0]['Telephone'][] = ['PhoneNumber' => $value_to_map, 'PhoneTechType' => 'PHONE'];
    }
}

function set_guest_emails(&$data, $value_to_map) {
    $data['ResGuest']['Profiles'][0]['Emails'][] = $value_to_map;
}

?>