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
                'AddressLine' => $value_to_map['address'],
                'CityName' => $value_to_map['city'],
                'CountryCode' => $value_to_map['countrycode']
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
 * provisioned us through Hostify PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_reservation_guest_counts(&$data, $value_to_map)
{
    if (empty($data['RoomStay']['GuestCounts'])) {
        $data['RoomStay']['GuestCounts'][] = [
            'AgeQualifyingCode' => 'adults',
            'Count' => $value_to_map
        ];
    }
}


/**
 * This will set reservation comments array to Reservation key mapper data
 * provisioned us through Hostify PMS request.
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

function set_reservation_child_counts(&$data, $value_to_map)
{
    /** Reflect data  for a Single Reservation Comment */
    if (!empty($value_to_map)) {
        $data['RoomStay']['GuestCounts'][] = [
            'AgeQualifyingCode' => 'children',
            'Count' => $value_to_map
        ];
    }
}

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

function set_property_facility_infos(&$data, $value_to_map)
{
    if (isset($value_to_map) && count($value_to_map) > 0) {
        foreach ($value_to_map as $key => $guest_room) {
            $data['FacilityInfo']['HotelUnits']['HotelUnit'][$key] = [
                'Id' => $guest_room['id'],
                'Name' => $guest_room['name'],

            ];
        }
    }

    $data['FacilityInfo']['HotelUnits']['TotalUnits'] = count($value_to_map);
}

?>